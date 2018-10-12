<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class SongController extends Controller
{
    protected function getEmptySong()
    {
        return [
            'id' => null,
            'name' => null,
            'code' => null,
            'author_id' => null
        ];
    }

    protected function findSong($id)
    {
        $query = "
            SELECT *
            FROM `songs`
            WHERE `id` = ?
        ";
        return (array)DB::selectOne($query, [$id]);
    }

    protected function selectAuthorsForSelect()
    {
        $query = "
            SELECT *
            FROM `authors`
            WHERE 1
            ORDER BY `authors`.`name` ASC
        ";
        $rs = DB::select($query);

        $authors = [];
        foreach ($rs as $row) {
            $authors[$row->id] = $row->name;
        }

        return $authors;
    }

    protected function wrapContent($content, $current = null)
    {
        return view('common/html_wrapper', [
            'header' => view('common/header', [
                'current' => $current
            ]),
            'footer' => view('common/footer'),
            'content' => $content
        ]);
    }

    //
    public function create()
    {
        // create empty SONG
        $song = $this->getEmptySong();
 
        // display the form
        return $this->wrapContent(view('song/edit', [
            'song' => $song,
            'authors' => $this->selectAuthorsForSelect()
        ]));
    }
 
    public function edit(Request $request)
    {
        // retrieve existing SONG from database
        $id = $request->input('id');
        $song = $this->findSong($id);

        if (!$song) {
            return abort(404);
        }
 
        // display the form
        return $this->wrapContent(view('song/edit', [
            'song' => $song,
            'authors' => $this->selectAuthorsForSelect()
        ]));
    }
 
    public function store(Request $request)
    {
        if ($id = $request->input('id')) {
            // retrieve existing SONG from database
            $song = $this->findSong($id);
        } else {
            // create empty SONG
            $song = $this->getEmptySong();
        }
 
        // update SONG from $_POST
        foreach ($song as $key => $value) {
            if ($request->has($key)) { 
                $song[$key] = $request->input($key);
            }
        }
 
        // SKIP VALIDATION IN LARAVEL
 
        // save the data
        if ($request->input('id')) {
            $query = "
                UPDATE `songs`
                SET `name` = ?,
                    `code` = ?,
                    `author_id` = ?
                WHERE `id` = ?
            ";
            // $values is $song after removing 'id' from the beginning and putting it at the end
            // (to reflect the order of ? in the query)
            $values = array_merge(array_slice(array_values($song), 1), [$song['id']]);
            DB::update($query, $values);
        } else {
            $query = "
                INSERT INTO `songs`
                (`name`, `code`, `author_id`)
                VALUES
                (?, ?, ?)
            ";
            // $values is $song after removing 'id' from the beginning
            $values = array_slice(array_values($song), 1);
            DB::insert($query, $values);
 
            $song['id'] = DB::getPdo()->lastInsertId();
        }
 
        // inform the user
        session()->flash('success_message', 'Success!');
 
        // redirect (ideally to the edit page of the inserted song)
        return redirect('/songs/edit?id='.$song['id']);
    }

    public function listing(Request $request)
    {
        $query = "
            SELECT `songs`.*,
                `authors`.`name` AS author_name
            FROM `songs`
            LEFT JOIN `authors`
                ON `songs`.`author_id` = `authors`.`id`
            WHERE 1
            ORDER BY `songs`.`name` ASC
        ";
        $songs = DB::select($query);

        $video = null;
        if ($id = $request->input('id')) {
            $video = $this->findSong($id);
        }

        return $this->wrapContent(view('song/list', [
            'songs' => $songs,
            'video' => $video
        ]));
    }

    public function delete(Request $request)
    {
        if ($request->method() == 'POST' && $request->input('delete')) {

            $id_to_delete = $request->input('id');

            $query = "
                DELETE
                FROM `songs`
                WHERE `id` = ?
            ";

            DB::delete($query, [$id_to_delete]);
        }

        return redirect('/songs');
    }
}
