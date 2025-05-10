<?php

class PasswdManager
{
    public static function regeneratePasswd()
    {
        $stmt = DB::get()->query("SELECT username FROM users");
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $lines = ["[users]"];
        foreach ($entries as $row) {
            $lines[] = $row['username'] . " = placeholder_password";
        }

        file_put_contents(PASSWD_FILE, implode("\n", $lines));
    }
}
