<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="data:image/x-icon;" type="image/x-icon">
    <title>Welcome, Strafred Page</title>
    <style>
        html,body {
            overflow: hidden;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
        }

        .stafred a {
            text-decoration: none;
            color: #727272;
            font-weight: 100;
            padding: 5px;
            border: 4px solid transparent;
            border-radius: 6px;
            font-size: smaller;
        }

        .stafred a:hover {
            background: #f5f5f5;
        }

        .stafred a:active {
            border: 4px solid #e5e5e5;
            background: #efefef;
        }

        .stafred {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            text-align: center;
        }
        .stafred > .title {
            font-size: 2.6em;
            font-weight: 400;
            color: #747474;
            padding-left: 0.7em;
            letter-spacing: 0.7em;
        }

        .stafred > .link {
            margin: 10px 0;
            display: flex;
            justify-content: center;
            text-transform: uppercase;
        }

        .timing {
            position: fixed;
            width: 100%;
            bottom: 1%;

        }

        .date {
            position: absolute;
            bottom: 5%;
            font-size: 0.8em;
            width: 100%;
            text-align: center;
            font-weight: 600;
            color: #b7b7b7;
        }
    </style>
</head>
<body>

    <div class="stafred">
        <div class="title">STAFRED</div>
        <div class="link">
            <a href="#">Get Start</a>
            <a href="#">Docs</a>
            <a href="https://github.com/stafred" target="_blank">GitHub</a>
            <a href="#">Async Event</a>
            <a href="#">Queue</a>
        </div>
    </div>

    <div class="date">
        stafred @ <?=date("Y");?>
    </div>
</body>