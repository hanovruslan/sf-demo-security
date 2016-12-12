curl -s -o /dev/null -w "%{http_code}\r\n" -H 'X-AUTH-TOKEN: foo' --head http://sf-security-demo.prod/
curl -s -o /dev/null -w "%{http_code}\r\n" -H 'X-AUTH-TOKEN_: foo' --head http://sf-security-demo.prod/
curl -s -o /dev/null -w "%{http_code}\r\n" -H 'X-AUTH-TOKEN: foo_' --head http://sf-security-demo.prod/
curl -s -o /dev/null -w "%{http_code}\r\n" -H 'X-AUTH-TOKEN: foo' --head http://sf-security-demo.prod/admin
curl -s -o /dev/null -w "%{http_code}\r\n" -H 'X-AUTH-TOKEN_: foo' --head http://sf-security-demo.prod/admin
curl -s -o /dev/null -w "%{http_code}\r\n" -H 'X-AUTH-TOKEN: foo_' --head http://sf-security-demo.prod/admin