<?php
function followCounter(PDO $dbh,  int $userId): int
{
    $sth = $dbh->prepare("SELECT COUNT(*) 
    FROM follow 
    WHERE followed = :user_id");
    $sth->execute([":user_id" => $userId]);
    return (int) $sth->fetchColumn();
}
