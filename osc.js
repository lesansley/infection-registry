//if an object is passed it just returns that object back again
//otherwise it asssumes an id is passed and returns the object associated with the id
function O(obj) {return typeof obj == 'object' ? obj : document.getElementById(obj)}

//returns the style property of the object passed
function S(obj) {return O(obj).style}

//access all elements of a particular class on a page
function C(name) {return document.getElementsByClassName(name)}


