<?php

class Article
{
    public $id;

    public $title;

    public $content;

    public $published_at;

    public $errors = [];

    public static function getAll($conn)
    {
        $sql = "SELECT *
                FROM artykul
                ORDER BY published_at;";

        $results = $conn->query($sql);

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPage($conn, $limit, $offset, $only_published = false)
    {

        $condition = $only_published ? 'WHERE published_at IS NOT NULL' : '';

        $sql = "SELECT a.*, category.name AS category_name
                FROM (
                    SELECT *
                    FROM artykul
                    $condition
                    ORDER BY published_at
                    LIMIT :limit
                    OFFSET :offset) AS a
                LEFT JOIN article_category
                ON a.id = article_category.article_id
                LEFT JOIN category
                ON article_category.category_id = category.id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $articles = [];

        $previous_id = null;

        foreach ($results as $row) {

            $article_id = $row['id'];

            if ($article_id != $previous_id) {
                $row['category_names'] = [];

                $articles[$article_id] = $row;
            }

            $articles[$article_id]['category_names'][] = $row['category_name'];

            $previous_id = $article_id;
        }

        return $articles;
    }

    public static function getByID($conn, $id, $columns = '*')
    {
        $sql = "SELECT $columns
                FROM artykul
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Article');

        if ($stmt->execute()) {

            return $stmt->fetch();

        }
    }

    public static function getWithCategories($conn, $id, $only_published = false)
    {
        $sql = "SELECT artykul.*, category.name AS category_name
                FROM artykul
                LEFT JOIN article_category
                ON artykul.id = article_category.article_id
                LEFT JOIN category
                ON article_category.category_id = category.id
                WHERE artykul.id = :id";

        if($only_published) {
            $sql .= ' AND artykul.published_at IS NOT NULL';
        }

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getCategories($conn)
    {
        $sql = "SELECT category.*
                FROM category
                JOIN article_category
                ON category.id = article_category.category_id
                WHERE article_id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($conn)
    {
        if ($this->validate()) {

            $sql = "UPDATE artykul
                    SET title = :title,
                        content = :content,
                        published_at = :published_at
                    WHERE id = :id";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);

            if ($this->published_at == '') {
                $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
            }

            return $stmt->execute();

        } else {
            return false;
        }
    }


    public function setCategories($conn, $ids)
    {
        if ($ids) {

            $sql = "INSERT IGNORE INTO article_category (article_id, category_id)
                    VALUES ";

            $values = [];

            foreach ($ids as $id) {
                $values[] = "({$this->id}, ?)";
            }

            $sql .= implode(", ", $values);

            $stmt = $conn->prepare($sql);

            foreach ($ids as $i => $id) {
                $stmt->bindValue($i + 1, $id, PDO::PARAM_INT);
            }

            $stmt->execute();
        }

        $sql = "DELETE FROM article_category
                WHERE article_id = {$this->id}";

        if ($ids) {

            $placeholders = array_fill(0, count($ids), '?');

            $sql .= " AND category_id NOT IN (" . implode(", ", $placeholders) . ")";

        }

        $stmt = $conn->prepare($sql);

        foreach ($ids as $i => $id) {
            $stmt->bindValue($i + 1, $id, PDO::PARAM_INT);
        }

        $stmt->execute();
    }

    protected function validate()
    {
        if ($this->title == '') {
            $this->errors[] = 'Wpisz tytu??';
        }
        if ($this->content == '') {
            $this->errors[] = 'Wpisz tre???? artyku??u';
        }

        if ($this->published_at != '') {
            $date_time = date_create_from_format('Y-m-d', $this->published_at);

            if ($date_time === false) {

                $this->errors[] = 'B????dna data';

            } else {

                $date_errors = date_get_last_errors();

                if ($date_errors['warning_count'] > 0) {
                    $this->errors[] = 'B????dna data';
                }
            }
        }

        return empty($this->errors);
    }

    public function delete($conn)
    {
        $sql = "DELETE FROM artykul
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function create($conn)
    {
        if ($this->validate()) {

            $sql = "INSERT INTO artykul (title, content, published_at)
                    VALUES (:title, :content, :published_at)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);

            if ($this->published_at == '') {
                $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                $this->id = $conn->lastInsertId();
                return true;
            }

        } else {
            return false;
        }
    }

    public static function getTotal($conn, $only_published = false)
    {
        $condition = $only_published ? 'WHERE published_at IS NOT NULL' : '';

        return $conn->query('SELECT COUNT(*) FROM artykul $condition')->fetchColumn();
    }

    public function publish($conn)
    {
        $sql = "UPDATE artykul
                SET published_at = :published_at
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        $published_at = date("Y-m-d");
        $stmt->bindValue(':published_at', $published_at, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $published_at;
        }
    }
}
