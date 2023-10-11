<!DOCTYPE html>
<html>

  <head> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&family=Nunito+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"/>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale="1.0"/><link rel="stylesheet" href="styles.css">
    <title>Php Core Documentation</title>
    </head>

  <body>
    
    <main id="main-doc">
      

     <nav id="navbar">
      <header id="header">Php Core Documentation</header>
      <ul>
       <li> <a href="#introduction" class="nav-link"> Introduction </a> </li>
       <li> <a href="#prerequisites" class="nav-link"> Prerequisites </a> </li>
       <li> <a href="#Java_and_Javascript" class="nav-link"> Php and PDO </a> </li>
       <li> <a href="#Hello_World" class="nav-link"> Basic Classes and Objects</a> </li>
       <li> <a href="#data_types" class="nav-link"> Data types </a> </li>
       <li> <a href="#variables" class="nav-link"> Variables </a> </li>
       <li> <a href="#if...else_statement" class="nav-link"> If...else Statement </a> </li>
       <li> <a href="#reference" class="nav-link"> Reference </a> </li>
     </ul>
    </nav>

      <section class="main-section" id="introduction"> 
    
        <header> Introduction </header>
        <p> Php Core is a :
       <ul> <li> Server-side Php extends the core .</li>
       <li>Server-side Php . </li>
    </ul>
    </p>
   </section>

     <section class="main-section" id="prerequisites">
       <header> Prerequisites </header>
       <p>
        This guide assumes :
         <ul> 
           <li> A general understanding of the  </li>
        <li> Good working knowledge of . </li>
        <li> Some programming experience. </li>
      </ul>
    </p>
    </section >
    
    <section class="main-section" id="Java_and_Javascript">
      <header> Pho Objects and Classes </header>
      <p> Php and PDo ... 
        </p> 
    </section>
   
    <section class="main-section" id="Hello_World">
      <header> Hello Php Core</header>
      <p> To get started withw:
        
        <code> function greetMe(yourName) { alert("Hello " + yourName); }
        greetMe("World"); </code>
        </p>
    </section>
   
    <section class="main-section" id="data_types">
      <header> Data Types </header>
      <p> The latest ECMAScript standard defines seven data types:
<ul>
    <li>Six data types that are primitives:
      <ul>
        <li>Boolean. true and false.</li>
        <li>null. A special keyword denoting a null value. Because JavaScript is case-sensitive, null is not the same as Null, NULL, or any other variant.</li>
        <li>undefined. A top-level property whose value is undefined.</li>
        <li>Number. 42 or 3.14159. </li>
        <li>String. "Howdy"</li>
        <li> Symbol (new in ECMAScript 2015). A data type whose instances are unique and immutable. </li>
        </ul>
   <li> and Object </li>
</ul>
        Although these data types are a relatively small amount, they enable you to perform useful functions with your applications. Objects and functions are the other fundamental elements in the language. You can think of objects as named containers for values, and functions as procedures that your application can perform. </p>
    </section>
   
    <section class="main-section" id="variables">
      <header> Variables </header>
      <p>  You use </p>
    </section>
    
</html>

@media only screen and (max-width: 600px) {
  #main-doc{
    position: absolute;
    margin: 0;
  }

  #navbar{
    position: fixed;
    top: 0;
    border-right: none;
    height: 50%;
    width: auto;

  }
}



main{
  font-family: "Nunito sans", tahoma;
  font-size: 18px;
  line-height: 30px;
  padding: 10px;
  position: absolute;
  margin-left: 30%;
}

section{
  height: 100%;
  width: 100%;
  position: relative;
  top: 0; 
}

header{
  font-family: "Nanum Gothic", tahoma;
  font-weight: 700;
  font-size: 1.5rem;
  margin: 5%;
}

p{
  margin-left: 8%;
}

code {
display: block;
margin-left: 0;
overflow: wrap;
background-color: GhostWhite;
border-radius: 7px;
padding: 12px;
}

a{
  margin: 10%;
}

#navbar{
  height: 100%;
  width: 30%;
  border-right: 3px solid #a3a0a0;
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
}

nav  ul{
  display: flex;
  flex-wrap: wrap;
  align-content: space-evenly;
  height: 100%;
  padding: 0;
  
}

nav > ul > li{
  border-top: 2px solid #8f8f8f;
  height: 8%;
  margin: 10px;
  width: 100%;
 
}

li > a {
  text-decoration: none;
  color: black; 
}