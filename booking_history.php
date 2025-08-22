<?php
// booking_history.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        td {
    color: black;        /* make text visible */
    font-weight: 500;    /* make it clearer */
    opacity: 1;          /* ensure full visibility */
}
        th {
            background: #007BFF;
            color: #fff;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        #reloadBtn {
            margin: 15px 0;
            padding: 10px 20px;
            border: none;
            background: #28a745;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
        }
        #reloadBtn:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <h2>Booking History</h2>

    <table id="bookingTable" border="1">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Movie</th>
      <th>Poster</th>
      <th>Theater</th>
      <th>Location</th>
      <th>Showtime</th>
      <th>Seats</th>
      <th>Total Amount</th>
      <th>Booking Date</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<button id="reloadBtn">Reload</button>

   <script>
function loadBookings() {
    fetch("get_bookings.php")
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector("#bookingTable tbody");
            tbody.innerHTML = ""; // clear old rows

            if (!data || data.length === 0) {
                tbody.innerHTML = "<tr><td colspan='12'>No bookings found</td></tr>";
                return;
            }

            data.forEach(row => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${row.id}</td>
                    <td>${row.name}</td>
                    <td>${row.email}</td>
                    <td>${row.phone}</td>
                    <td>${row.movie_title}</td>
                    <td><img src="${row.poster}" alt="${row.movie_title}" width="60"></td>
                    <td>${row.theater_name}</td>
                    <td>${row.theater_location}</td>
                    <td>${row.showtime}</td>
                    <td>${row.seats}</td>
                    <td>${row.total_amount}</td>
                    <td>${row.booking_date}</td>
                `;
                tbody.appendChild(tr);
            });
        })
        .catch(err => console.error("Error loading bookings:", err));
}

// Load on page load
window.onload = loadBookings;

// Reload button
document.getElementById("reloadBtn").addEventListener("click", loadBookings);
</script>

</body>
</html>
