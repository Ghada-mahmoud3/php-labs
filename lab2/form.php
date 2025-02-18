<form method="post" action="code.php">
    <label for="fname">First Name:</label>
    <input id="fname" type="text" name="fname"><br><br>
    <label for="lname">Last Name:</label>
    <input id="lname" type="text" name="lname"><br><br>
    <label for="address">Address:</label><br>
    <textarea name="address" id="address" cols="30" rows="4"></textarea><br><br>
    
    <label for="country">Country:</label>
    <select name="country" id="country">
        <option>Select country</option>
        <option value="egypt">EGYPT</option>
        <option value="usa">USA</option>
        <option value="australia">Australia</option>
    </select><br><br>

    <label for="gender">Gender:</label>
    <input type="radio" name="gender" id="male" value="male">
    <label for="male">Male</label>
    <input type="radio" name="gender" id="female" value="female">
    <label for="female">Female</label><br><br>

    <label for="skills">Skills:</label>
    <div style="width:100px; display:inline;">
        <input type="checkbox" name="skills[]" value="php">
        <label for="php">PHP</label>
        <input type="checkbox" name="skills[]" value="java">
        <label for="java">Java</label>
        <input type="checkbox" name="skills[]" value="python">
        <label for="python">Python</label>
    </div><br><br>

    <label for="uname">UserName:</label>
    <input id="uname" type="text" name="uname"><br><br>
    
    <label for="passwd">Password:</label>
    <input id="passwd" type="password" name="passwd"><br><br>
    
    <select name="Department" id="department">
        <option value="op">Open Source</option>
        <option value="ui">UI/UX</option>
        <option value="pwd">PWD</option>
    </select><br><br>

    <input type="submit" value="Submit" name="submit">
    <input type="reset" name="reset">
</form>
