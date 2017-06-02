<?php

namespace Site\Models;

class Albums
{
  public $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function getAll()
  {
    $query = $this->db->query('SELECT * FROM covers');
    $covers = $query->fetchAll();

    return $covers;
  }

  public function getById($id)
  {
    $prepare = $this->db->prepare('
			SELECT * FROM songs WHERE album_id = :id 
		');
    $prepare->bindValue('id', $id);
    $prepare->execute();
    $album = $prepare->fetchAll();
    
    return $album;
  }

  private function _getSongsByAlbumId($id)
  {
    $prepare = $this->db->prepare('
			SELECT
				*
			FROM
				covers AS c
			LEFT JOIN
				songs AS s
			ON
				s.album_id = c.id
			WHERE
				c.id = :album_id
		');
    $prepare->bindValue('album_id', $id);
    $prepare->execute();
    $songs = $prepare->fetchAll();

    return $songs;
  }
}