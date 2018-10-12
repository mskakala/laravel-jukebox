<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    protected function getEmptyAuthor()
    {
        return [
            'id' => null,
            'name' => null,
            'img_url' => null
        ];
    }

    protected function findAuthor($id)
    {
        $query = "
            SELECT *
            FROM `authors`
            WHERE `id` = ?
        ";
        return (array)DB::selectOne($query, [$id]);
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
        // create empty AUTHOR
        $author = $this->getEmptyAuthor();
 
        // display the form
        return $this->wrapContent(view('author/edit', [
            'author' => $author
        ]));
    }
 
    public function edit(Request $request)
    {
        // retrieve existing AUTHOR from database
        $id = $request->input('id');
        $author = $this->findAuthor($id);

        if (!$author) {
            return abort(404);
        }
 
        // display the form
        return $this->wrapContent(view('author/edit', [
            'author' => $author
        ]));
    }
 
    public function store(Request $request)
    {
        if ($id = $request->input('id')) {
            // retrieve existing AUTHOR from database
            $author = $this->findAuthor($id);
        } else {
            // create empty AUTHOR
            $author = $this->getEmptyAuthor();
        }
 
        // update AUTHOR from $_POST
        foreach ($author as $key => $value) {
            if ($request->has($key)) { 
                $author[$key] = $request->input($key);
            }
        }
 
        // SKIP VALIDATION IN LARAVEL
 
        // save the data
        if ($request->input('id')) {
            $query = "
                UPDATE `authors`
                SET `name` = ?,
                    `img_url` = ?
                WHERE `id` = ?
            ";
            // $values is $author after removing 'id' from the beginning and putting it at the end
            // (to reflect the order of ? in the query)
            $values = array_merge(array_slice(array_values($author), 1), [$author['id']]);
            DB::update($query, $values);
        } else {
            $query = "
                INSERT INTO `authors`
                (`name`, `img_url`)
                VALUES
                (?, ?)
            ";
            // $values is $author after removing 'id' from the beginning
            $values = array_slice(array_values($author), 1);
            DB::insert($query, $values);
 
            $author['id'] = DB::getPdo()->lastInsertId();
        }
 
        // inform the user
        session()->flash('success_message', 'Success!');
 
        // redirect (ideally to the edit page of the inserted author)
        return redirect('/authors/edit?id='.$author['id']);
    }

    public function listing(Request $request)
    {
        $query = "
            SELECT `authors`.*
            FROM `authors`
            WHERE 1
            ORDER BY `authors`.`name` ASC
        ";
        $authors = DB::select($query);

        return $this->wrapContent(view('author/list', [
            'authors' => $authors
        ]));
    }

    public function delete(Request $request)
    {
        if ($request->method() == 'POST' && $request->input('delete')) {

            $id_to_delete = $request->input('id');

            $query = "
                DELETE
                FROM `authors`
                WHERE `id` = ?
            ";

            DB::delete($query, [$id_to_delete]);
        }

        return redirect('/authors');
    }
}
