##facebook-control-campaign-status

- 啟用/停用 選取的 campaigns ids
- 在 星期六 零晨 00:00:00 停止這些 ids
- 在 星期一 零晨 00:00:00 啟用這些 ids

```sh
# campaigns ids active/pause to crontab
0 0 * * 6 php -q /path/shell/run-pause.php
0 0 * * 1 php -q /path/shell/run-active.php
```