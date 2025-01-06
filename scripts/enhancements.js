/**
 * Author: Thi Ngan Ha Do
 * Target: index.html and about.html
 * Purpose: Magnifying Pictures and Table reordering
 * Create: 20/04/2024
 * Last update: 26/04/2024
 * Credits: SouthBride, W3Schools, Geeks for geeks forum
 */

"use strict";

// Function to handle row reordering
function handleRowReorder() {
    // Get the table body element
    const tbody = document.querySelector(".todo_list tbody");
    // Check if tbody exists before accessing its rows
    if (!tbody) return;

    // Get all rows in the table body
    const rows = tbody.rows;

    // Loop through each row
    for (var i = 0; i < rows.length; i++) { 
        var row = rows[i];
        // Enable drag and drop functionality for the row
        row.setAttribute('draggable', true);
        // Add 'draggable' class to the row
        row.classList.add('draggable');

        // Event listener for when dragging starts
        row.addEventListener('dragstart', (event) => {
            // Add 'dragging' class to the row
            event.target.classList.add('dragging');
            // Apply styling for the selected row when dragging starts
            event.target.style.color = '#4B6D90'; // Change text color
            event.target.style.fontWeight = 'bold'; // Make text bold
        });

        // Event listener for when dragging ends
        row.addEventListener('dragend', (event) => {
            // Remove 'dragging' class from the row
            event.target.classList.remove('dragging');
        });

        // Event listener for when dragging over a row
        row.addEventListener('dragover', (event) => {
            // Prevent default behavior
            event.preventDefault();
        });

        // Event listener for when dropping a row
        row.addEventListener('drop', (event) => {
            // Prevent default behavior
            event.preventDefault();
            // Get the dragged row and the target row
            const draggedRow = document.querySelector('.dragging');
            const targetRow = event.target.closest('tr');

            // If there is no target row or it's the same as the dragged row, exit
            if (!targetRow || targetRow === draggedRow) {
                return;
            }

            // Insert the dragged row before the target row
            tbody.insertBefore(draggedRow, targetRow);

            // Remove blue highlight from the last moved row
            // Track the last moved row
            var lastMovedRow = null;
            if (lastMovedRow) {
                lastMovedRow.style.color = ''; // Reset text color
                lastMovedRow.style.fontWeight = ''; // Reset font weight
            }

            // Set the current dragged row as the last moved row
            lastMovedRow = draggedRow;
            lastMovedRow.style.color = '#4B6D90'; 
            lastMovedRow.style.fontWeight = 'bold'; 
        });
    }
}

// Execute row reorder handler when the document is loaded
document.addEventListener("DOMContentLoaded", function () {
    // Execute row reorder handler
    handleRowReorder();

    // Drag and drop functionality for individual cells
    document.addEventListener("dragstart", function(event) {
        draggedCell = event.target;
    });

    document.addEventListener("dragover", function(event) {
        event.preventDefault();
    });

    document.addEventListener("drop", function(event) {
        event.preventDefault();
        var targetCell = event.target.closest("td"); // Find the closest <td> parent

        if (targetCell && targetCell.classList.contains("droppable")) {
            // Swap the innerHTML of the two cells
            var temp = targetCell.innerHTML;
            targetCell.innerHTML = draggedCell.innerHTML;
            draggedCell.innerHTML = temp;

            // Keep the last moved row styled
            // Track the last moved row
            var lastMovedRow = null;
            if (lastMovedRow) {
                lastMovedRow.style.color = '#4B6D90'; // Change text color
                lastMovedRow.style.fontWeight = ''; // Reset font weight
            }
        }
    });
});

// Magnify function
function magnify(imgID, zoom) {
    var img = document.getElementById(imgID);
    // Check if img exists before proceeding
    if (!img) return;

    var magnifier = document.getElementById("magnifier");
    var container = img.parentElement;

    // Set background image for magnifier
    magnifier.style.backgroundImage = "url('" + img.src + "')";
    magnifier.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";

    // Calculate initial position for magnifier
    var magX = container.offsetWidth - magnifier.offsetWidth;
    var magY = container.offsetHeight - magnifier.offsetHeight;

    // Set initial position for magnifier
    magnifier.style.left = magX + "px";
    magnifier.style.top = magY + "px";

    // Execute a function when mouse moves over the image
    img.addEventListener("mousemove", moveMagnifier);

    function moveMagnifier(e) {
        var pos = getCursorPos(e);
        var x = pos.x;
        var y = pos.y;

        // Set background position to show magnification
        magnifier.style.backgroundPosition = -(x * zoom) + "px " + -(y * zoom) + "px";
    }

    function getCursorPos(e) {
        var a = img.getBoundingClientRect();
        var x = e.pageX - a.left;
        var y = e.pageY - a.top;
        x = x - window.scrollX;
        y = y - window.scrollY;
        return { x: x, y: y };
    }
}

magnify("imgZoom", 3);
handleRowReorder();