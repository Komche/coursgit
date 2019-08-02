<?php
function bdd()
{
    $dbname = 'moi';
    $user = 'root';
    $pass = '';
    try {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $bdd = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", "$user", "$pass", $pdo_options);
    } catch (Exception $e) {
        die('Erreur :' . $e->getMessage());
    }
    return $bdd;
}

function like($id, $likes)
{
    $sql = "UPDATE article SET likes=:likes WHERE id_article=:id";
    $req = PaginationData::connexion()->prepare($sql);
    $req->execute(array(
        'likes' => $likes,
        'id' => $id
    ));
    return 1;
}

function get_var_name($var)
{
    foreach ($GLOBALS as $var_name => $value) {
        if ($value === $var) {
            return $var_name;
        }
    }
    return false;
}

function extract_get($index)
{
    if (!empty($_GET[$index])) {
        return $GLOBALS[$index] = $_GET[$index];
    } else {
        return $GLOBALS[$index] = null;
    }
}

function getArticle($id = null, $category = null, $apgination = null)
{

    if (!empty($id)) {
        $sql = "SELECT *
        FROM article WHERE id_article=:id GROUP BY id_article DESC";

        $req = PaginationData::connexion()->prepare($sql);
        $req->execute(array('id' => $id));

        if ($result = $req->fetchAll()) {

            return $result;
        }
    } elseif ($apgination != null && $category != null) {
        $result = PaginationData::getFAQ($category, 'article', 'id_article', 'type', 'index.php?');
        return $result;
    } else {
        $sql = "SELECT *
        FROM article WHERE type=:category GROUP BY id_article DESC ";

        $req = PaginationData::connexion()->prepare($sql);
        $req->execute(array('category' => $category));
        if ($result = $req->fetchAll()) {

            return $result;
        }
    }
}


function currentPage($url = null, $go = null)
{
    $server = $_SERVER['SERVER_NAME'];
    if ($url != null) {
        if ($server === 'localhost') {
            $page = $_SERVER['SCRIPT_NAME'];
            $p = str_replace("/prodec/", "", $page);
            if ($p == $url) {
                return 'active';
            }
        } else {
            $page = $_SERVER['SCRIPT_NAME'];
            $p = str_replace("/", "", $page);
            if ($p == $url) {
                return 'active';
            }
        }
    } elseif ($go != null) {
        if ($server === 'localhost') {
            $page = $_SERVER['SCRIPT_NAME'];
            $p = str_replace("/prodec/", "", $page);
            return $p;
        } else {
            $page = $_SERVER['SCRIPT_NAME'];
            $p = str_replace("/", "", $page);
            return $p;
        }
    }
}

function getFilesInIdex($folder = null)
{
    $sql = "SELECT * FROM files WHERE folder=:folder";

    $req = PaginationData::connexion()->prepare($sql);
    $req->execute(array('folder' => $folder));
    if ($result = $req->fetchAll()) {

        return $result;
    }
}

function Unaccent($string)
{
    return preg_replace('~&([a-z\'`]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml|caron);~i', '$1', htmlentities($string, ENT_COMPAT, 'UTF-8'));
}
