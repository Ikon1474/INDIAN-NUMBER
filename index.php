<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Number Info API</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#0f172a;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.container{
    width:100%;
    max-width:700px;
    background:#1e293b;
    border-radius:20px;
    padding:25px;
    box-shadow:0 0 30px rgba(0,0,0,.3);
}

h1{
    color:#fff;
    text-align:center;
    margin-bottom:20px;
}

.subtitle{
    color:#94a3b8;
    text-align:center;
    margin-bottom:25px;
}

.input-group{
    display:flex;
    gap:10px;
}

input{
    flex:1;
    padding:15px;
    border:none;
    border-radius:12px;
    outline:none;
    background:#334155;
    color:#fff;
    font-size:16px;
}

button{
    padding:15px 25px;
    border:none;
    border-radius:12px;
    background:#2563eb;
    color:#fff;
    cursor:pointer;
    font-size:16px;
    font-weight:bold;
}

button:hover{
    background:#1d4ed8;
}

.loading{
    display:none;
    text-align:center;
    color:#fff;
    margin-top:20px;
}

.result{
    display:none;
    margin-top:20px;
    background:#0f172a;
    border-radius:15px;
    padding:20px;
}

.row{
    display:flex;
    justify-content:space-between;
    padding:10px 0;
    border-bottom:1px solid #334155;
}

.row:last-child{
    border:none;
}

.label{
    color:#94a3b8;
}

.value{
    color:#fff;
    font-weight:bold;
}

.footer{
    text-align:center;
    margin-top:20px;
}

.footer a{
    color:#3b82f6;
    text-decoration:none;
}

.copy-btn{
    width:100%;
    margin-top:15px;
    background:#16a34a;
}

.copy-btn:hover{
    background:#15803d;
}

pre{
    margin-top:15px;
    background:#020617;
    color:#22c55e;
    padding:15px;
    border-radius:10px;
    overflow:auto;
}
</style>
</head>
<body>

<div class="container">

    <h1>📱 Number Info API</h1>

    <p class="subtitle">
        Get Country, Region, Format & Validation Info
    </p>

    <div class="input-group">
        <input type="text" id="number" placeholder="+919876543210">
        <button onclick="lookup()">Search</button>
    </div>

    <div class="loading" id="loading">
        Searching...
    </div>

    <div class="result" id="result"></div>

    <div class="footer">
        API By:
        <a href="https://t.me/username_506" target="_blank">
            @username_506
        </a>
    </div>

</div>

<script>

async function lookup(){

    const number = document.getElementById("number").value.trim();

    if(!number){
        alert("Enter a phone number");
        return;
    }

    document.getElementById("loading").style.display="block";
    document.getElementById("result").style.display="none";

    try{

        const response = await fetch(
            "/api?number=" + encodeURIComponent(number)
        );

        const data = await response.json();

        document.getElementById("loading").style.display="none";

        let html = "";

        for(let key in data){

            html += `
            <div class="row">
                <div class="label">${key}</div>
                <div class="value">${data[key]}</div>
            </div>
            `;
        }

        html += `
        <button class="copy-btn" onclick='copyJson(${JSON.stringify(JSON.stringify(data))})'>
            Copy JSON
        </button>

        <pre>${JSON.stringify(data,null,2)}</pre>
        `;

        document.getElementById("result").innerHTML = html;
        document.getElementById("result").style.display="block";

    }catch(error){

        document.getElementById("loading").style.display="none";

        document.getElementById("result").innerHTML =
        "<div style='color:red'>API Error</div>";

        document.getElementById("result").style.display="block";
    }
}

function copyJson(text){

    navigator.clipboard.writeText(JSON.parse(text));

    alert("JSON Copied");
}

</script>

</body>
</html>