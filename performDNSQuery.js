function performDNSQuery() {
  var domainInput = document.getElementById("domain-input");
  var domain = domainInput.value.trim();
  var extractedDomain = extractDomain(domain);

  if (extractedDomain) {
    domain = extractedDomain;
  }

  var url = "https://sm2.doh.pub/dns-query?name=" + encodeURIComponent(domain);

  Utils.ajaxRequest(url, function(response) {
    var data = JSON.parse(response);
    var table = document.getElementById("result-table");
    table.innerHTML = "";

    var thead = document.createElement("thead");
    var headerRow = document.createElement("tr");

    var nameHeader = document.createElement("th");
    nameHeader.innerText = "域名";
    headerRow.appendChild(nameHeader);

    var typeHeader = document.createElement("th");
    typeHeader.innerText = "类型";
    headerRow.appendChild(typeHeader);

    var ttlHeader = document.createElement("th");
    ttlHeader.innerText = "TTL";
    headerRow.appendChild(ttlHeader);

    var expiresHeader = document.createElement("th");
    expiresHeader.innerText = "过期时间";
    headerRow.appendChild(expiresHeader);

    var dataHeader = document.createElement("th");
    dataHeader.innerText = "数据";
    headerRow.appendChild(dataHeader);

    thead.appendChild(headerRow);
    table.appendChild(thead);

    var tbody = document.createElement("tbody");

    var typeMap = {
      1: "A",
      2: "NS",
      3: "MD",
      4: "MF",
      5: "CNAME",
      6: "SOA",
      7: "MB",
      8: "MG",
      9: "MR",
      10: "NULL",
      11: "WKS",
      12: "PTR",
      13: "HINFO",
      14: "MINFO",
      15: "MX",
      16: "TXT",
      17: "RP",
      18: "AFSDB",
      19: "X25",
      20: "ISDN",
      21: "RT",
      22: "NSAP",
      23: "NSAP-PTR",
      24: "SIG",
      25: "KEY",
      26: "PX",
      27: "GPOS",
      28: "AAAA",
      29: "LOC",
      30: "NXT",
      31: "EID",
      32: "NIMLOC",
      33: "SRV",
      34: "ATMA",
      35: "NAPTR",
      36: "KX",
      37: "CERT",
      38: "A6",
      39: "DNAME",
      40: "SINK",
      41: "OPT",
      42: "APL",
      43: "DS",
      44: "SSHFP",
      45: "IPSECKEY",
      46: "RRSIG",
      47: "NSEC",
      48: "DNSKEY",
      49: "DHCID",
      50: "NSEC3",
      51: "NSEC3PARAM",
      52: "TLSA",
      53: "SMIMEA",
      55: "HIP",
      56: "NINFO",
      57: "RKEY",
      58: "TALINK",
      59: "CDS",
      60: "CDNSKEY",
      61: "OPENPGPKEY",
      62: "CSYNC",
      63: "ZONEMD",
      64: "SVCB",
      65: "HTTPS",
      99: "SPF",
      100: "UINFO",
      101: "UID",
      102: "GID",
      103: "UNSPEC",
      104: "NID",
      105: "L32",
      106: "L64",
      107: "LP",
      108: "EUI48",
      109: "EUI64",
      249: "TKEY",
      250: "TSIG",
      251: "IXFR",
      252: "AXFR",
      253: "MAILB",
      254: "MAILA",
      255: "*",
    };


    for (var i = 0; i < data.Answer.length; i++) {
      var answer = data.Answer[i];
      var row = document.createElement("tr");

      var nameCell = document.createElement("td");
      var name = answer.name;
      if (name.charAt(name.length - 1) === '.') {
        name = name.slice(0, -1); // 去除最后一位点号
      }
      nameCell.innerText = name;
      row.appendChild(nameCell);


      var typeCell = document.createElement("td");
      var typeName = typeMap[answer.type] || answer.type;
      typeCell.innerText = typeName;
      row.appendChild(typeCell);

      var ttlCell = document.createElement("td");
      ttlCell.innerText = answer.TTL;
      row.appendChild(ttlCell);

      var expiresCell = document.createElement("td");
      var formattedDate = formatDate(answer.Expires);
      expiresCell.innerText = formattedDate;
      row.appendChild(expiresCell);

      var dataCell = document.createElement("td");
      dataCell.innerText = answer.data;
      row.appendChild(dataCell);

      tbody.appendChild(row);
    }

    table.appendChild(tbody);

    var newUrl = window.location.origin + "/?name=" + encodeURIComponent(domain);
    window.history.pushState(null, "", newUrl);
  }, function(status) {
    console.log("请求失败。状态码：" + status);
  });
}
