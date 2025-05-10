<?php

class AuthzManager
{
    public static function regenerateAuthz()
    {
        $db = DB::get();
        $authz = "[groups]\n";
        $groupMap = [];

        // Groups
        $groups = $db->query("SELECT id, group_name FROM user_groups")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($groups as $group) {
            $stmt = $db->prepare("SELECT u.username FROM group_memberships gm JOIN users u ON gm.user_id = u.id WHERE gm.group_id = ?");
            $stmt->execute([$group['id']]);
            $usernames = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'username');
            $authz .= $group['group_name'] . " = " . implode(", ", $usernames) . "\n";
            $groupMap[$group['id']] = $group['group_name'];
        }

        $authz .= "\n";

        // Repositories
        $repos = $db->query("
            SELECT DISTINCT repository_name FROM repository_assignments
            UNION
            SELECT DISTINCT repository_name FROM repository_group_assignments
        ")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($repos as $repo) {
            $repoName = $repo['repository_name'];
            $authz .= "[$repoName:/]\n";

            // Individual user access
            $stmt = $db->prepare("SELECT u.username FROM repository_assignments ra JOIN users u ON ra.user_id = u.id WHERE ra.repository_name = ?");
            $stmt->execute([$repoName]);
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $user) {
                $authz .= $user['username'] . " = rw\n";
            }

            // Group access
            $stmt = $db->prepare("SELECT group_id FROM repository_group_assignments WHERE repository_name = ?");
            $stmt->execute([$repoName]);
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $authz .= "@" . $groupMap[$row['group_id']] . " = rw\n";
            }

            $authz .= "\n";

            // Exclusions
            $stmt = $db->prepare("SELECT path, excluded_for_users FROM repository_exclusions WHERE repository_name = ?");
            $stmt->execute([$repoName]);
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $excl) {
                $path = trim($excl['path'], "/");
                $authz .= "[$repoName:/$path]\n";
                $excluded = explode(",", $excl['excluded_for_users']);
                foreach ($excluded as $uid) {
                    $user = $db->prepare("SELECT username FROM users WHERE id = ?");
                    $user->execute([trim($uid)]);
                    $username = $user->fetchColumn();
                    if ($username) {
                        $authz .= $username . " =\n";
                    }
                }
                $authz .= "\n";
            }
        }

        file_put_contents(AUTHZ_FILE, $authz);
    }
}
