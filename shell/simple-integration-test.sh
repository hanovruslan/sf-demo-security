#!/usr/bin/env bash

curl -s -o /dev/null -w "%{http_code}\r\n" -H "X-AUTH-TOKEN: foo" --head http://sf-security-demo.prod/
curl -s -o /dev/null -w "%{http_code}\r\n" -H "X-AUTH-TOKEN_: foo" --head http://sf-security-demo.prod/
curl -s -o /dev/null -w "%{http_code}\r\n" -H "X-AUTH-TOKEN: foo_" --head http://sf-security-demo.prod/
curl -s -o /dev/null -w "%{http_code}\r\n" -H "X-AUTH-TOKEN: foo" --head http://sf-security-demo.prod/admin
curl -s -o /dev/null -w "%{http_code}\r\n" -H "X-AUTH-TOKEN_: foo" --head http://sf-security-demo.prod/admin
curl -s -o /dev/null -w "%{http_code}\r\n" -H "X-AUTH-TOKEN: foo_" --head http://sf-security-demo.prod/admin
curl -s -o /dev/null -w "%{http_code}\r\n" -H "X-AUTH-TOKEN: foo" -H "X-AUTH-USERNAME: foo" --head http://sf-security-demo.prod/morozov
curl -s -o /dev/null -w "%{http_code}\r\n" -H "X-AUTH-TOKEN_: foo" -H "X-AUTH-USERNAME_: foo" --head http://sf-security-demo.prod/morozov
curl -s -o /dev/null -w "%{http_code}\r\n" -H "X-AUTH-TOKEN: foo_" -H "X-AUTH-USERNAME: foo_" --head http://sf-security-demo.prod/morozov
curl -s -o /dev/null -w "%{http_code}\r\n" -H "X-AUTH-TOKEN: foo" --head http://sf-security-demo.prod/view
curl -s -o /dev/null -w "%{http_code}\r\n" -H "X-AUTH-TOKEN: foo" --head http://sf-security-demo.prod/edit
curl -s -o /dev/null -w "%{http_code}\r\n" -H "X-AUTH-TOKEN: bar" --head http://sf-security-demo.prod/edit
curl -s -o /dev/null -w "%{http_code}\r\n" -H "X-AUTH-TOKEN: bar" --head http://sf-security-demo.prod/view
