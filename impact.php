<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Impact</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    font-family: Arial;
    margin: 0;
    background: #f5f7fa;
}

/* NAVBAR */
.navbar {
    display: flex;
    justify-content: space-between;
    padding: 15px 60px;
    background: white;
    border-bottom: 1px solid #ddd;
}

.left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo {
    background: #16a34a;
    color: white;
    padding: 8px;
    border-radius: 6px;
}

/* MENU */
.menu span {
    margin-left: 20px;
    cursor: pointer;
    font-size: 14px;
}

.active {
    color: green;
}

/* CONTAINER */
.container {
    width: 1100px;
    margin: auto;
    padding: 30px 0;
}

/* TEXT */
.sub {
    color: gray;
    margin-bottom: 30px;
}

/* CARDS */
.cards {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    gap: 25px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 12px;
}

.icon {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-bottom: 10px;
}

.blue { background:#3b82f6; }
.green { background:#22c55e; }
.purple { background:#9333ea; }
.orange { background:#f97316; }

.green-text {
    color: green;
    font-size: 12px;
}

/* CHART */
.charts {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
    margin-top: 30px;
}

.box {
    background: white;
    padding: 20px;
    border-radius: 12px;
}

/* BREAKDOWN */
.breakdown {
    margin-top: 30px;
    background: white;
    padding: 25px;
    border-radius: 12px;
}

.break-grid {
    display: grid;
    grid-template-columns: repeat(3,1fr);
    text-align: center;
    margin-top: 20px;
}

.circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    margin: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
}

.blue-bg { background:#dbeafe; color:#2563eb; }
.green-bg { background:#dcfce7; color:#16a34a; }
.purple-bg { background:#f3e8ff; color:#9333ea; }

/* ACHIEVE */
.achieve {
    margin-top: 30px;
    background: #dff5e7;
    padding: 20px;
    border-radius: 12px;
}

.ach-card {
    margin-top: 10px;
    background: white;
    padding: 15px;
    border-radius: 10px;
    display: flex;
    gap: 10px;
}
</style>
</head>

<body>

<div class="navbar">
    <div class="left">
        <div class="logo">🌱</div>
        <b>GoGreen</b>
    </div>

    <div class="menu">
        <span>Dashboard</span>
        <span>Submit Waste</span>
        <span>Rewards</span>
        <span class="active">Impact</span>
        <span>Profile</span>
        <span>🔔</span>
        <span>Logout</span>
    </div>
</div>

<div class="container">

<h2>Environmental Impact</h2>
<p class="sub">Your contribution to a sustainable future</p>

<div class="cards">

<div class="card">
<div class="icon blue">♻️</div>
<p>Total Waste Recycled</p>
<h3>0 kg</h3>
<span class="green-text">+12% this month</span>
</div>

<div class="card">
<div class="icon green">🌲</div>
<p>Trees Planted</p>
<h3>0</h3>
</div>

<div class="card">
<div class="icon purple">☁️</div>
<p>CO₂ Reduced</p>
<h3>0.0 kg</h3>
</div>

<div class="card">
<div class="icon orange">📈</div>
<p>Environmental Score</p>
<h3>0</h3>
</div>

</div>

<div class="charts">

<div class="box">
<h3>Waste Type Distribution</h3>
<canvas id="pie"></canvas>
</div>

<div class="box">
<h3>Monthly Contribution</h3>
<canvas id="bar"></canvas>
</div>

</div>

<div class="breakdown">
<h3>Your Environmental Impact Breakdown</h3>

<div class="break-grid">

<div>
<div class="circle blue-bg">♻️</div>
<h4>Recycling Impact</h4>
</div>

<div>
<div class="circle green-bg">🌲</div>
<h4>Reforestation</h4>
</div>

<div>
<div class="circle purple-bg">☁️</div>
<h4>Carbon Reduction</h4>
</div>

</div>
</div>

<div class="achieve">
<h3>Achievements</h3>

<div class="ach-card">
⭐ First Submission
</div>

</div>

</div>

<script>
new Chart(document.getElementById("pie"), {
type:'pie',
data:{
labels:["Plastic","Paper","Glass"],
datasets:[{data:[40,30,30]}]
}
});

new Chart(document.getElementById("bar"), {
type:'bar',
data:{
labels:["Jan","Feb","Mar"],
datasets:[{data:[0,0,0]}]
}
});
</script>

</body>
</html>