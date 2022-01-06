<img src="https://1.tilyanpristka.id/images/tP-logo-rounded.png" height="111" align="right">

# <img src="https://1.tilyanpristka.id/images/tagui.png" height="45" align="left"> TagUI <img src="https://1.tilyanpristka.id/images/telegram.png" height="45"> Telegram Send Attachment
Improve `TagUI` Feature to be able to `Send Telegram with Attachments`

#### How to do that
- Open `src/tagui_parse.php` then look for the `function telegram_intent`, then replace the contents of the function with the one in this file: [tagui_parse.php](https://raw.githubusercontent.com/tilyanPristka/TagUI-Telegram-Attachment/main/tagui_parse.php)
- Prepare your server (vps, hosting), then upload these 2 files to your server:
  (Before you can see this first: https://github.com/kelaberetiv/TagUI/tree/master/src/telegram)
  - [upload_doc.php](https://raw.githubusercontent.com/tilyanPristka/TagUI-Telegram-Attachment/main/upload_doc.php) I set all uploaded files to be in a folder with the name `storage`.
  - [sendAttachment.php](https://raw.githubusercontent.com/tilyanPristka/TagUI-Telegram-Attachment/main/sendAttachment.php) join this in the same path as the `sendMessage.php` which is default from TagUI. And don't forget to fill in the Telegram API Token in this file.


#### Testing
Create file .tag for test send attachments or just run this file [teleAttachments.tag](https://raw.githubusercontent.com/tilyanPristka/TagUI-Telegram-Attachment/main/teleAttachments.tag) 
>telegram `CHAT_ID` [your attachment file path (use `,` for separate multi attachments)] `TEXT_MESSAGE`

![trigger telegram](https://1.tilyanpristka.id/images/TagUI-trigger-telegram.png)

#### Result
![trigger telegram](https://1.tilyanpristka.id/images/Telegram-Result.png)
