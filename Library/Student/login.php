<?php require_once('../Admin/includes/database.php');
      require_once('../Admin/includes/students.php');
      
session_start();

    
    if(isset($_POST['submit'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $student = Student::find_student_by_username_password($username, $password);

        if($student) {
            $_SESSION['id'] = $student->id;
            header("Location: index.php");
            exit();
        }
    }


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/login.css">
    <title>Sign in to your library account</title>
</head>

<body>

    <main>
        <div class="outer">
            <div class="middle">
                <div class="inner">
                    <div class="banner">
                        <div class="logo"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAVsSURBVGhD7ZhLbFR1FMYHxY1uRBMXKIh2kKFYoNIHAy2lZWgKLcUChRb6oC22FCJESGhiY0pCeCQSwQjaakgg4YJUJCoT5GHoCMbEha90wUoiCzcsFDWRqO13/H+3pzdz6bSdO23aMekv+XLv+c65/+/cJs1MxjfBBBOMH9ObZcrUV7GI4r3a/x+mbcfUZ5vx0Yxm9M7YJmLL3BvvHHs6ltzMbJZQShPuGv3r34r3/c1SbqsJH9BjjzM6noS0yUOBV/BGoBE9RrdnNSJDOw702LNnzCyf0VZyEKjGk2lbEE7bIsJragOe0NYA2Iue5bPaGhte2oLc9Hq8Pb8eHQPUgJ+NetIb0OrzySR9ZAhkEmf5jP1sjDOZtaBOcvSB0SFrM3Iz6tCTWYe/zfXXfmXWidjajLtZ9cjX8bjhM3y2/xz32XZWz6i+zMIaHAvW4J9gFZ5iPbcKj5n6dLBWJFiLm6b/tD0Yg9duYh6l5QD4LM+wzzJn8mz6zLIza/GOPTga5FTByqmWe7zPq5VATjW6c6sBo7cWNMoj9tADiMik/RF8eOBLEVsRnKWnbRc8g2fxTJ7NDPrMZLY9NBosNYctrZJ7BdVSnr8Jf5j697xNWKftmLx3BYs7vhCJVvs1BLUdE57Js5nBLGYyW9sjZ3klrMJKoLBSxFy7Q5WYqa1BOX8Z+ecvi7g1/P8Rz2aGZoHZ2hoZRZvwzIoNuLWyQmRlBU6VlMij2hqSzk55OHJRIkaiitDT9pAwg1nMZDZ30FZilGxAYel63C0tx/1V5dKodtx0dcnk7gsooXivdtwwk9ncgbuo7Y0167CnbC16jW6vXTvwU3qsYDZ3MOrhTmrHx7oyFK9fI1K+Bpc2Fo//t1buwF24k9mtSO3h2fgy2jaWiVSUJs83Ve7CnSrLzHe0eKkulVDNapGaUnSba2dSqG8X7uTtG0R9CbYa/diwCj+Z659GvbzvF2v60d5IFEfGD+Z+q66XGE3FsJqK+z7Z+2FNX8sRMxYZvm1FsLavcIewpq+li52r5fFtK+RQLLGnYy68ZiTETnPYjiJ3CGv6WrrYEZLpO4tEYok9HXPhNSMhdi2HtavQHcKavpYjZiwyfHuWwWoJuUNY09fSoS1PJu8pQEVLCC2xxB5ndNzBS0bCtBbAas13h7Cmr6XD6wVoay0QGUqc0XEHLxkJszcPlvkrukJY09fSYe9SXDT+L23L5PlYYo8zOu7gJSNh9pnD9i1xh7Cmr6XDviUIG/+OlgNgjzNaOnjJSJiDObAO5bhDWNPX0sF44YO5g78Ie5zR0sFLRsIcXgTr8GJ3CGv6WjocXoyw8V0vYuprbwaxQ+/vcMZuROElI2GOBGEdDbpDWNPX0uHoQoSPLHS/iJmVo0G8y3v2OGM3ovCSkTDHsmEdy3aHsKavpYPxwkauFzmeLXI8q+9F2OOM3YiCZ8WbkTDtGbA6Mt0hrOlr6WC8cHum+0Xas6WxI7vv9yn2OGM3ovCSkTAnzGEnMtwhrOlr6WC8sNGg/+zscUZLB54Vb0bCnEyHdSrdHcKavpYOp9IRNv6gL8IeZ7R08JLhmbNzMO3MfOw2+v7MPNw/PQ8t/WJNP9pT/5bxf3vQ7xd7nInhD5phtJu76FreOZeG7zrniiSH8K2u5Z0LL8q9j9NwIpwmU8ZT3IG76Fre+GQ2sj9LxV+fpkrEqHGcFeEuF1ORpevFx+UASi7NBj6fLZJM4k7cTdccnqsv4MC1WSJXA8i7EpAFySDuYu9kdtM1h+e6Hwe6ZopcT8Fqcw0lg3QX6fJjv645PDdSUHTDj96bfpFkEnf6yu/xN+BvUjDn6+ekPJnEnXS9CSaYwBM+339aONeiptWJGwAAAABJRU5ErkJggg=="></div>
                        <div>KU Library</div>
                    </div>

                 <form method="post" action="login.php">
                    <div>
                        <div class="sign-in-tittle">
                            Sign in
                        </div>

                        <input type="text" class="id_password" placeholder="username" name="username">
                        <input type="password" class="id_password" placeholder="Password" name="password">
                    </div>
                    
                    <div class="button-holder">
                        <input type="submit" value="Login" name="submit">
                    </div>
                 </form>


                </div>
            </div>
        </div>

        <div class="footer">
            <div class="footer-links">
                <span>&copy Library</span>
                <span>About</span>
                <span>More</span>
            </div>
        </div>
    </main>

</body>

</html>