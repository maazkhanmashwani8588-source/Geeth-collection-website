<?php include("includes/header.php"); ?>

<!DOCTYPE html>
<html>
<head>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial;
    background:#f5f7fb;
    padding:20px;
}

/* ABOUT CONTAINER */
.about{
    width:100%;
    max-width:800px;
    margin:50px auto;
    background:#fff;
    padding:40px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    text-align:center;
    transition:0.3s;
}

.about:hover{
    transform:translateY(-5px);
}

/* MAIN TITLE */
h1{
    margin-bottom:20px;
    font-size:34px;
    color:#111;
}

/* PARAGRAPH */
p{
    color:#555;
    line-height:1.8;
    font-size:16px;
}

/* SECTION */
.section{
    margin-top:30px;
}

.section h3{
    color:#ff4da6;
    margin-bottom:10px;
    font-size:22px;
}

/* ================= TABLET ================= */
@media (max-width:768px){

    body{
        padding:15px;
    }

    .about{
        padding:30px;
    }

    h1{
        font-size:28px;
    }

    .section h3{
        font-size:20px;
    }

    p{
        font-size:15px;
    }
}

/* ================= MOBILE ================= */
@media (max-width:480px){

    body{
        padding:10px;
    }

    .about{
        padding:20px;
        margin:25px auto;
        border-radius:10px;
    }

    h1{
        font-size:24px;
    }

    .section{
        margin-top:25px;
    }

    .section h3{
        font-size:18px;
    }

    p{
        font-size:14px;
        line-height:1.7;
    }
}
</style>

</head>

<body>

<div class="about">

<h1>About Geet Collection</h1>

<p>
Geet Collection is your go-to destination for modern fashion and stylish clothing.
We combine quality, comfort, and affordability to deliver the best shopping experience.
</p>

<div class="section">
    <h3>Our Mission</h3>
    <p>
        To provide trendy, high-quality clothing that empowers people to express their style confidently.
    </p>
</div>

<div class="section">
    <h3>Our Vision</h3>
    <p>
        To become a leading fashion brand known for innovation, quality, and customer satisfaction.
    </p>
</div>

</div>

</body>
</html>

<?php include("includes/footer.php"); ?>