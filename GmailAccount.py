#901427636262-hi863tsc42ihv9jq8o25tj5pgdsqkuat.apps.googleusercontent.com
import ezgmail
import pprint
#ezgmail.send("basil_anton@yahoo.ca",'Test Message','Body of Test Message')
#unread_threads = ezgmail.unread() # returns a GmailThread object of all unread threads
#ezgmail.summary(unread_threads) #gives a summary for every thread

threads = ezgmail.search('after:2026/02/01 before:2026/02/06')
for thread in threads:
    print("THREAD:", thread.messages[0].snippet)

#print(ezgmail.summary(threads))