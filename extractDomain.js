function extractDomain(url) {
  var domainRegex = /^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/im;
  var matches = domainRegex.exec(url);
  if (matches && matches.length > 1) {
    return matches[1].toLowerCase();
  }
  return null;
}
