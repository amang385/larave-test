<?php

namespace App\Http\Controllers;
use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(){

        $books = Book::all();
        // dd($books);
        return view('book.index',compact('books'));
    }
    public function createPage(){

        // $books = Book::all();
        // dd(55);
        return view('book.create');
    }

    public function create(Request $request)
    {       
        // dd($request->all());
        // dd($request->name);

        $book = new Book();
        
        $book->name = $request->name;
        $book->author = $request->author;
        $book->price = $request->price;
        $book->describe = $request->describe;
        $book->type = $request->type;

        // dd($book->save());

        if(!$book->save()){
            return redirect()->route('book.create.page');
        }
        return redirect()->route('book.index');
             
    }
    public function editPage($id){
        $book = Book::find($id);
        // dd(book);
        return view('book.edit',['book'=>$book]);
    }

    public function edit(Request $request){

        $book = Book::find($request->id);
        $book->name = $request->name;
        $book->author = $request->author;
        $book->price = $request->price;
        $book->describe = $request->describe;
        $book->type = $request->type;

       if(!$book->save()){
           return redirect()->route('book.edit.page');
        }
        return redirect()->route('book.index');
    }

    
    public function delete(Book $id){


        
//         dd(Auth::user());
//         if(empty(Auth::user())){

// return redirect()->route('login.index');
//         }


        $id->delete();
        return redirect()->route('book.index');
    }
}
