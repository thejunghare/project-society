<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Maintence Invoice</title>

    <style>
        body {
            font-family: 'Times New Roman', Times, serif
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 12px;
            text-align: center;
        }



        li {
            list-style-type: none;
        }

        .pdf-header {
            border-bottom: 1px dotted black;
            display: grid;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .society-name {
            color: red;
        }

        .pdf-details {
            position: relative;
        }

        .pdf-details-child {
            position: absolute;
            width: 50%;
            /* top: 50%; */
        }

        .pdf-details-child:nth-child(1) {
            left: 0;
        }

        .pdf-details-child:nth-child(2) {
            right: 0;
        }

        .pdf-table {
            margin: 100px auto 20px auto;

        }

        .pdf-footer-info {
            border-top: 2px dotted black;
        }

        .pdf-footer-info>ul>li {

            list-style-type: disc;
        }
    </style>
</head>

<body>
    <div class="pdf-header">
        <h2 class="society-name">Vighaneshwar Cooperative Housing Society</h2>
        <p>Plot B-420, Sector 4, Ghansoli, Navi Mumbai, Maharashtra 400701</p>
    </div>

    <div class="pdf-details">
        <div class="pdf-details-child">
            <ul>
                <li>Name: Prasad Shridhar Junghare</li>
                <li>Mobile Number: 9004289600</li>
                <li>Room Number: 1132</li>
            </ul>
        </div>
        <div class="pdf-details-child">
            <ul>
                <li>Bill Number : 1325</li>
                <li>Bill Date: 01/03/2024</li>
                <li>Due Date: 15/03/2024</li>
                <li>Bill Period: March 2024</li>
            </ul>
        </div>
    </div>

    <table class="pdf-table" style="width:100%">
        <tr>
            <th>Sr. No.</th>
            <th>Head</th>
            <th>Description</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Parking Charges</td>
            <td></td>
            <td>0.00</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Services Charges</td>
            <td></td>
            <td>500.00</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Repair and maintenance fund</td>
            <td></td>
            <td>500.00</td>
        </tr>
        <tr>
            <th colspan="3">Total</th>
            <th>500.00</th>
        </tr>
    </table>

    <div class="pdf-footer-info">
        <ul>
            <li>
                This is computer generated bill hence signature is not required.
            </li>
            <li>
                Please write your flat number and mobile number on backside of each cheque.
            </li>
            <li>
                Online payment accepted society's bank account.
            </li>
        </ul>
    </div>
</body>

</html>
