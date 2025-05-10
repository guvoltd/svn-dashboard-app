<?php

class SvnService
{
    private static function run($cmd)
    {
        $escapedCmd = escapeshellcmd($cmd);
        exec($escapedCmd . ' 2>&1', $output, $status);
        return ['status' => $status, 'output' => $output];
    }

    public static function createBranch($repoPath, $fromPath, $branchName)
    {
        $cmd = "svn copy file://$repoPath/$fromPath file://$repoPath/branches/$branchName -m 'Creating branch $branchName'";
        return self::run($cmd);
    }

    public static function diffVersions($repoPath, $path, $rev1, $rev2)
    {
        $cmd = "svn diff -r $rev1:$rev2 file://$repoPath/$path";
        return self::run($cmd);
    }
}
