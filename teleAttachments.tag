telegram CHAT_ID [storage/exist.csv,storage\exist0.csv,storage\exist1.csv,storage\img.jpg] test1 multi attachments all file is exist
telegram CHAT_ID [C:\tagui\storage\exist3.csv,storage/img.png,not_found.csv] test2 multi attachments 2 file is exist n 1 not exist
telegram CHAT_ID [storage/exist.csv] test3 1 attachment but file is exist
telegram CHAT_ID [C:\tagui\storage\not_found.csv] test4 1 attachment but file is not exist
telegram CHAT_ID [] test5 attachment but with blank path
telegram CHAT_ID test6 without attachment