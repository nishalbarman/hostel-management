<style>
.popup {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    visibility: hidden;
    opacity: 0;
    z-index: -1;
    transition: all 0.3s ease-out;
}

.popup-content {
    background: white;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    width: 50%;
    max-width: 500px;
    height: auto;
    padding: 30px;
}

.popup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.popup-header h2 {
    margin: 0;
    font-size: 1.5em;
    font-weight: bold;
}

.close-button {
    font-size: 1.5em;
    font-weight: bold;
    cursor: pointer;
}

.popup-body {
    line-height: 1.5;
    height: auto;
}

.popup.show {
    visibility: visible;
    opacity: 1;
    z-index: 100;
}

li {
    padding: 0;
    display: block;
    list-style: none;
    margin: 10px 0 0 0;
}

label {
    margin: 0 0 3px 0;
    padding: 0px;
    display: block;
    font-weight: bold;
}

input[type="text"],
input[type="date"],
input[type="datetime"],
input[type="number"],
input[type="search"],
input[type="time"],
input[type="url"],
input[type="email"],
textarea,
select {
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    border: 1px solid #bebebe;
    padding: 7px;
    margin: 0px;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    outline: none;
}

input[type="text"]:focus,
input[type="date"]:focus,
input[type="datetime"]:focus,
input[type="number"]:focus,
input[type="search"]:focus,
input[type="time"]:focus,
input[type="url"]:focus,
input[type="email"]:focus,
textarea:focus,
select:focus {
    -moz-box-shadow: 0 0 8px #88d5e9;
    -webkit-box-shadow: 0 0 8px #88d5e9;
    box-shadow: 0 0 8px #88d5e9;
    border: 1px solid #88d5e9;
}

.field-divided {
    width: 49%;
}

.field-long {
    width: 100%;
}

.field-select {
    width: 100%;
}

.field-textarea {
    height: 100px;
}

input[type="submit"],
input[type="button"] {
    background: #4b99ad;
    padding: 8px 15px 8px 15px;
    border: none;
    color: #fff;
}

input[type="submit"]:hover,
input[type="button"]:hover {
    background: #4691a4;
    box-shadow: none;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
}

.required {
    color: red;
}

.filed-radio {
    display: flex;
}
</style>



<div class="popup" id="popup">
    <div class="popup-content">
        <div class="popup-header">
            <h2>Add Room</h2>
            <span class="close-button" id="close-button">&times;</span>
        </div>
        <div class="popup-body" id="popup-body">

            <li>
                <label>Room No <span class="required">*</span></label>
                <input type="number" name="roomno" class="field-long" required />
            </li>

            <li>
                <label>Seats <span class="required">*</span></label>
                <input type="number" name="seat" class="field-long" required />
            </li>
            <center>
                <button id="add-room"
                    style="background-color: green; color: white; font-size: 16px; padding: 10px 20px; border: none; cursor: pointer; float:center;margin-top:20px;"
                    onclick="">Add
                    Room</button>
            </center>
        </div>
    </div>
</div>
</div>

<script>
// Get the popup element
const popup = document.getElementById('popup');

// Get the close button element
const closeButton = document.getElementById('close-button');

// Show the popup when the page loads
// window.addEventListener('load', function() {
//     popup.classList.add('show');
// });

// Hide the popup when the close button is clicked
closeButton.addEventListener('click', function() {
    popup.classList.remove('show');
});

// Hide the popup when the user clicks outside the popup content
window.addEventListener('click', function(event) {
    if (event.target == popup) {
        popup.classList.remove('show');
    }
});
</script>