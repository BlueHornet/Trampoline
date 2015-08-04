#!/usr/bin/env python

import sys
import os
import re

## Sample environment variables
#    USER=handler
#    DOMAIN=mydomain.com
#    LOGNAME=handler
#    CLIENT_PROTOCOL=ESMTP
#    ORIGINAL_RECIPIENT=inbox@mydomain.com
#    LOCAL=handler
#    PATH=/usr/bin:/bin
#    SENDER=john@example.com
#    LANG=C
#    CLIENT_ADDRESS=10.0.0.1
#    MAIL_CONFIG=/etc/postfix
#    PWD=/var/spool/postfix
#    RECIPIENT=handler@mydomain.com
#    CLIENT_HOSTNAME=unknown
#    CLIENT_HELO=smtp.example.com


# Route message based on original recipient
try:
    [user, domain] = os.environ.get('ORIGINAL_RECIPIENT').split('@')
except:
    print "Bad recipient or no recipient found"
    quit()

print "Processing message for:", [user, domain]