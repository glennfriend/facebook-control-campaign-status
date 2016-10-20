##facebook-control-campaign-status

- 啟用/停用 選取的 campaigns ids
- 在 星期六 零晨 00:00:00 停止這些 ids
- 在 星期一 零晨 00:00:00 啟用這些 ids

```
run-save-active-to-ini.php
    -> call fb & get all active
    -> save file (只存 active)
    -> 接近星期六的時間之前執行
run-active.php
    -> get file
    -> call fb & pause it
    -> 星期六零晨執行
run-pause.php
    -> get file
    -> call fb & active it
    -> 星期一零晨執行


# campaigns ids active/pause to crontab
30 23 * * 5 php -q /_path_/shell/run-save-active-to-ini.php
0 0 * * 6   php -q /_path_/shell/run-pause.php
0 0 * * 1   php -q /_path_/shell/run-active.php
```