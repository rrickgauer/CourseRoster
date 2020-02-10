# Course Roster

![Course Roster logo](src/img/logo.png)

<img src="https://github.com/sindresorhus/pure/blob/master/screenshot.png?raw=true" width="864">

## Website
www.courseroster.com

## Background
Course Roster is a project I created for [Northern Illinois University](https://www.niu.edu/index.shtml) students to see what courses other NIU students are taking in a given semester. After [signing up](https://courseroster.com/createAccount.php) for an account, students can then search for a course by dept and add it to their “roster”. Users can also search for other users by first and last name, or email to see what courses they are registered for. Users also have the option to follow other students so they can quickly reference them whenever they choose.

Every semester I found myself asking several of my friends if they were taking a certain class. I thought if there was some way that I could just look the information up online and see for myself, instead of pestering my friends, it would make everyone’s life a little easier. That’s how I came up with the idea for Course Roster.


## Technologies

In order to get all the class information such as the department, course number, and title, I wrote a simple [python](https://www.python.org/) script that scrapes NIU’s [course catalog](http://catalog.niu.edu/content.php?catoid=48&navoid=2305) on their website that has all the information listed. Then I saved them all into a mysql table.

### Back-end
* [PHP](https://www.php.net/)
* [MySQL](https://www.mysql.com/)

### Front-end
* HTML/CSS
* [Javascript](https://www.javascript.com/)
* [Bootstrap 4](https://getbootstrap.com/)
* [Boxicons](https://boxicons.com/)
* [Select2](https://select2.org/)
