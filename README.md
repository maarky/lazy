Lazy Loading
============

This library provides a basic means of lazy loading. If you are sick of writing code like the following then you can 
benefit from this class.

    class Whatever
    {
        public $something;
        
        public function getSomething()
        {
            if(!$something) {
                $this->something = 'something';
            }
            return $this->something;
        }
    }

There are a number of issues with this approach:

* There's annoying boilerplate code.
* The actual value of $something might evaluate as false which means you need more boilerplate code.
* Your class has to know how to get $something.

Usage
-----

Imagine you have an Author object and a getArticles() metod that returns an array of all articles by this author.
If you use this object in 100 places throughout your code but you only need the list of their articles in half of those 
places you aren't going to want to load the articles every time you create an Author object since the time
spent will often be wasted.

The Lazy\Container class constructor takes a callback that accepts no arguments and returns any value. The get() method calls the 
function, stores the returned value and returns it. If you ever call the get() method again it will not call your 
function but will instead just return the previously generated value.

Here's an example where a repository class creates your Author instances:

    class AuthorRepository
    {
        public function find($id)
        {
            //query db for author with the given id
            //resulting an an array called $row
            
            $function = function() use($id) {
                return $this->articleRepository->findByAuthor($id)
            };
            $row['articles'] = new \maarky\Lazy\Container($function);
            return new Author($row);
        }
    }
    
    class Author
    {
        public function getArticles()
        {
            return $this->articles->get();
        }
    }

As you can see, the getArticles() method doesn't need to know anything about how the articles are retrieved or whether
or not they have already been retrieved. It just needs to get the value from the Lazy\Container object and leaves it to that
object to worry about the details.

Warning
-------

It is important to know that this value will only be generated once. This means that it is intended to be immutable. If
any change in the application or the object containing the Lazy\Container object changes and requires a new value for 
that Lazy\Container object then you should not use this class for that.

This behavior is intentional and it is a feature, not a bug.