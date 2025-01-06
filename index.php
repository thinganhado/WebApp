<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.inc'; ?>
</head>
<body class="index_body">
<!--Navigation bar-->
    <?php include 'menu.inc'; ?>
    <hr class="special">
<section class="index_content">
   <h2 class="prompt_index">Welcome!</h2>
<section class="article_index">
    <hr>
    <input type="radio" id="toggle1" class="toggle-radio" name="toggle" checked>
    <label class="title" id="title1" for="toggle1">ABOUT US</label>
    <input type="radio" id="toggle2" class="toggle-radio" name="toggle">
    <label class="title" id="title2" for="toggle2">PAST PROJECTS</label>
    <!--Two articles: users can access by selecting the titles-->
    <div class="content" id="content1">
        <p class="prompt_index">Revolutionize financial systems, <br> 
            Prioritizing security and compliance.</p>
        <p>At Reboot, we specialize in building software solutions for financial institutions, 
            with a focus on modernizing their systems and overall customer experience. Our solutions 
            include online banking platforms, mobile banking apps, payment gateway integrations, and 
            custom software development to meet the specific needs of our clients. We understand the 
            critical importance of data security and compliance, and we prioritize these elements in 
            all our software solutions.
        </p>
    </div>
    <div class="content" id="content2">
        <p class="prompt_index">Ultimate ORM solution.</p>
        <p>ORM Cloud is an operational risk management and compliance platform that governs operational 
            risk, regulatory compliance, model risk, and financial controls management. At our core, we 
            are a powerful management system that centralizes incident reporting, KRIs automation, and 
            real-time analytics.
        </p>
    </div>
</section>
<!--Images to illustrate articles-->
<section class="graphic">
    <hr>
    <p id="title3">Founded by a team of professionals with extensive experience in finance and software 
        development, the company emerged from a shared aspiration to address the evolving needs of financial 
        institutions in an increasingly digital landscape.</p>
<div class="image-container">
    <figure class="zoom">
        <a href="https://www.artsy.net/artwork/mark-stopforth-dot-dot-dot-estuary-light-dot-dot-dot">
            <img src="images/article.png" alt="Article" class="zoom-image" id="imgZoom"> <!-- Add this line -->
        </a>
        <div class="magnifier" id="magnifier"></div>
    </figure>
</div>
</section>
</section>
    <?php include 'footer.inc'; ?>
</body>
</html>