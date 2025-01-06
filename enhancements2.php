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
   <h2>Drag and Drop Table Rows</h2>
   <p><strong>Description</strong>: This feature allows users to reorder rows in a table, which is a helpful way to rearrange items in lists such as a to-do list</p>
   <p><strong>Trigger</strong>: Clicking and holding on a row of the table</p>
    <p><a href="https://www.youtube.com/watch?v=8mfL-tOdn1M">SouthBride on Youtube</a> achieves this effect by handling the row reordering:</p>
    <ul>
        <li><strong>'draggable'</strong>: Assigns draggable attribute to each row</li>
        <li><strong>'dragstart'</strong>: Sets event listener to drag the row to the event target</li>
        <li><strong>'dragover'</strong>: Sets event listener to reorder the rows</li>
    </ul>
    <p> Here is what I did differently:</p>
        <ul>
            <li><strong>'dragstart'</strong>: Adds event listener and applies styling to the selected row (ondragstart Event: <a href="https://www.w3schools.com/jsref/event_ondragstart.asp">Reference</a>)</li>
            <li><strong>'drop'</strong>: Sets event listener to prevent default behavior and reorder the row to the target row</li>
            <li><strong>var lastMovedRow</strong>: Keeps track of the last moved row and applies additional styling to it</li>
        </ul>
    <p>This effect can be viewed here: <a href="about.html">About webpage</a></p>
</section>
<section id="enhancement2">
    <h2>Image Magnifier Glass</h2>
    <p><strong>Description</strong>: This feature creates the effect of a magnifying glass following the mouse cursor over the image, allowing users to inspect the image in more detail</p>
    <p><strong>Trigger</strong>: Mouse movement over the image</p>
    <p><a href="https://www.w3schools.com/howto/howto_js_image_magnifier_glass.asp">W3Schools</a> achieves this effect by handling the row reordering:</p>
    <ul>
        <li><strong>'magnify' function</strong>: Creates a magnifying glass (a div element) dynamically and inserts it into the DOM</li>
        <li><strong>'mousemove' + 'touchmove'</strong>: Sets event listener to trigger the magnification effect</li>
        <li><strong>'moveMagnifier' function</strong>: calculates the position of the magnifier based on the cursor's position, adjusts it to stay within the image boundaries, and updates the background position of the magnifier accordingly to show the magnification</li>
    </ul>
    <p> Here is what I did differently:</p>
        <ul>
            <li><strong>'magnifier' div</strong>: Directly places a div in HTML, keep magnify glass in the same place for aesthethics </li>
            <li><strong>'backgroundImage' + 'backgroundSize'</strong>: Sets to the URL of img.src and the calculated size based on the image's dimensions and the zoom level (Calculation: <a href="https://www.geeksforgeeks.org/how-to-create-image-magnifier-using-html-css-and-javascript/">Reference</a>)</li>
        </ul>
    <p>This effect can be viewed here: <a href="index.html">Home webpage</a></p>
</section>
</section>
    <?php include 'footer.inc'; ?>
    </body>
</html>