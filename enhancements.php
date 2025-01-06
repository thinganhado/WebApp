<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.inc'; ?>
</head>
<body>
<!--Navigation bar-->
    <?php include 'menu.inc'; ?>
    <hr class="special">
<section class="enhancements">
<section id="enhancement1">
   <h2>Collapsibles: Details element</h2>
    <p>Accordions are used to organize and present content of large size that users may not need to view all at once. 
    </p>
    <p><a href="https://www.w3schools.com/howto/howto_js_accordion.asp">W3School</a> achieves this effect with the combination of HTML, CSS, and JavaScript. Here is what I did:</p>
        <ul>
            <li><strong>details[open] .toggle_arrow</strong>: Rotates arrow when detailed description is opened (tranform property: <a href="https://dev.to/mori/create-a-css-toggle-button-with-the-element-2n9b">Reference)</a></li>
            <li><strong>.detailed_description{display: none;}</strong>: Hides the detailed description by default</li>
            <li><strong>details[open] .detailed_description</strong>: Displays the detailed description when the detailed_description element is open by changing its display property to block</li>
            <li><strong>summary::before</strong>: Add an arrow icon, making summary of job descriptions visually clickable by setting cursor</li>
        </ul>
    <p>This effect can be viewed here: <a href="jobs.html">Jobs webpage</a></p>
</section>
<section id="enhancement2">
    <h2>Magic Scroll: Animation</h2>
    <p>The magic scroll feature showcases a series of images in a sequence, mimicking a gallery layout.
    </p>
    <p><a href="https://www.magictoolbox.com/magicscroll/integration/">MagicToolbox</a> achieves this effect with the combination of HTML, CSS, and JavaScript. Here is what I did:</p>
        <ul>
            <li><strong>animation: scroll</strong>: Applies a scroll animation to the images <a href="https://www.w3schools.com/css/css3_animations.asp">(Reference)</a></li>
            <li><strong>animation-play-state: running</strong>: Sets the initial animation state to running</li>
            <li><strong>animation-play-state: paused</strong>:  Pauses the animation when the container is hovered over</li>
            <li><strong>@keyframes scroll</strong>: Specifies the state of the animation, which scrolls images offscreen to the left.</li>
        </ul>
    <p>This effect can be viewed here: <a href="about.html">About webpage</a></p>
</section>
</section>
    <?php include 'footer.inc'; ?>
    </body>
</html>