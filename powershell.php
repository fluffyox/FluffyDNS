<?php

/**
 * DNSQuery 类用于查询域名的 DNS 信息并生成数据表格展示。
 */
class DNSQuery
{
    private $domain;
    private $response;

    /**
     * 构造函数，初始化 DNSQuery 对象。
     *
     * @param string $domain 要查询的域名。
     */
    public function __construct($domain)
    {
        $this->domain = $domain;
    }

    /**
     * 从远程服务器获取域名的 DNS 数据。
     *
     * @return void
     */
    public function fetchDNSData()
    {
        $data = file_get_contents("https://sm2.doh.pub/dns-query?name={$this->domain}");
        $this->response = json_decode($data, true);
    }

    /**
     * 生成包含 DNS 数据的数据表格。
     *
     * @return void
     */
    public function generateTable()
    {
        if (!$this->response || !isset($this->response['Answer']) || !is_array($this->response['Answer'])) {
            $this->printError("err-107");
        }

        $tableData = $this->buildTableData();

        $this->printTable($tableData);
    }

    /**
     * 构建数据表格的数据。
     *
     * @return array 数据表格的数据。
     */
    private function buildTableData()
    {
        $tableData = [
            [
                'Domain' => 'Domain',
                'Type' => 'Type',
                'TTL' => 'TTL',
                'Expiration' => 'Expiration',
                'Data' => 'Data',
            ],
        ];

        foreach ($this->response['Answer'] as $entry) {
            $domain = $entry['name'];
            $type = $this->getTypeName($entry['type']);
            $ttl = $entry['TTL'];
            $expires = date('Y-m-d H:i:s', strtotime($entry['Expires']));
            $dataValue = $entry['data'];

            $tableData[] = [
                'Domain' => $domain,
                'Type' => $type,
                'TTL' => $ttl,
                'Expiration' => $expires,
                'Data' => $dataValue,
            ];
        }

        return $tableData;
    }

    /**
     * 根据 DNS 记录类型获取类型名称。
     *
     * @param int $type DNS 记录类型。
     * @return string 类型名称。
     */
    private function getTypeName($type)
    {
        $typeMap = [
            1 => 'A',
            2 => 'NS',
            3 => 'MD',
            4 => 'MF',
            5 => 'CNAME',
            6 => 'SOA',
            7 => 'MB',
            8 => 'MG',
            9 => 'MR',
            10 => 'NULL',
            11 => 'WKS',
            12 => 'PTR',
            13 => 'HINFO',
            14 => 'MINFO',
            15 => 'MX',
            16 => 'TXT',
            17 => 'RP',
            18 => 'AFSDB',
            19 => 'X25',
            20 => 'ISDN',
            21 => 'RT',
            22 => 'NSAP',
            23 => 'NSAP-PTR',
            24 => 'SIG',
            25 => 'KEY',
            26 => 'PX',
            27 => 'GPOS',
            28 => 'AAAA',
            29 => 'LOC',
            30 => 'NXT',
            31 => 'EID',
            32 => 'NIMLOC',
            33 => 'SRV',
            34 => 'ATMA',
            35 => 'NAPTR',
            36 => 'KX',
            37 => 'CERT',
            38 => 'A6',
            39 => 'DNAME',
            40 => 'SINK',
            41 => 'OPT',
            42 => 'APL',
            43 => 'DS',
            44 => 'SSHFP',
            45 => 'IPSECKEY',
            46 => 'RRSIG',
            47 => 'NSEC',
            48 => 'DNSKEY',
            49 => 'DHCID',
            50 => 'NSEC3',
            51 => 'NSEC3PARAM',
            52 => 'TLSA',
            53 => 'SMIMEA',
            55 => 'HIP',
            56 => 'NINFO',
            57 => 'RKEY',
            58 => 'TALINK',
            59 => 'CDS',
            60 => 'CDNSKEY',
            61 => 'OPENPGPKEY',
            62 => 'CSYNC',
            63 => 'ZONEMD',
            64 => 'SVCB',
            65 => 'HTTPS',
            99 => 'SPF',
            100 => 'UINFO',
            101 => 'UID',
            102 => 'GID',
            103 => 'UNSPEC',
            104 => 'NID',
            105 => 'L32',
            106 => 'L64',
            107 => 'LP',
            108 => 'EUI48',
            109 => 'EUI64',
            249 => 'TKEY',
            250 => 'TSIG',
            251 => 'IXFR',
            252 => 'AXFR',
            253 => 'MAILB',
            254 => 'MAILA',
            255 => '*',
        ];

        return $typeMap[$type] ?? '未知';
    }


    /**
     * 打印数据表格。
     *
     * @param array $tableData 数据表格的数据。
     * @return void
     */
    private function printTable($tableData)
    {
        $columnWidths = $this->calculateColumnWidths($tableData);

        echo "+" . implode("+", array_map(function ($width) {
                return str_repeat("-", $width + 2);
            }, $columnWidths)) . "+\n";

        foreach ($tableData as $row) {
            echo "| " . implode(" | ", array_map(function ($cellValue, $width) {
                    return str_pad($cellValue, $width, " ");
                }, $row, $columnWidths)) . " |\n";

            echo "+" . implode("+", array_map(function ($width) {
                    return str_repeat("-", $width + 2);
                }, $columnWidths)) . "+\n";
        }
    }

    /**
     * 计算每列数据的宽度。
     *
     * @param array $tableData 数据表格的数据。
     * @return array 包含列宽度的数组。
     */
    private function calculateColumnWidths($tableData)
    {
        $columnWidths = array_map(function ($columnName) use ($tableData) {
            return max(array_map(function ($row) use ($columnName) {
                return mb_strlen($row[$columnName], 'UTF-8');
            }, $tableData));
        }, array_keys($tableData[0]));

        return $columnWidths;
    }

    /**
     * 打印错误信息并退出脚本。
     *
     * @param string $errorCode 错误代码。
     * @return void
     */
    private function printError($errorCode)
    {
        exit("Error: $errorCode");
    }
}

$domain = $_GET['name'] ?? "";

if (strlen($domain) < 3 || $domain === "index.html") {
    exit("
  ______ _        __  __         _____  _   _  _____ 
 |  ____| |      / _|/ _|       |  __ \| \ | |/ ____|
 | |__  | |_   _| |_| |_ _   _  | |  | |  \| | (___  
 |  __| | | | | |  _|  _| | | | | |  | | . ` |\___ \ 
 | |    | | |_| | | | | | |_| | | |__| | |\  |____) |
 |_|    |_|\__,_|_| |_|  \__, | |_____/|_| \_|_____/ 
                          __/ |                      
                         |___/                       
    
Welcome to Fluffy DNS Query !

Usage: curl dq.amgl.work/DOMAIN

Example: curl dq.amgl.work/example.com
");
}

$dnsQuery = new DNSQuery($domain);
$dnsQuery->fetchDNSData();
$dnsQuery->generateTable();

?>
