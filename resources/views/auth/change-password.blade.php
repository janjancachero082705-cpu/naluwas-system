<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Change Password - Tingalan Naluwas Church</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 450px;
            width: 100%;
        }

        .card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
        }

        .header .icon {
            font-size: 60px;
            margin-bottom: 10px;
        }

        .header h2 {
            color: white;
            font-size: 24px;
            margin: 0;
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 13px;
            margin-top: 8px;
        }

        .body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-group label i {
            margin-right: 5px;
            color: #667eea;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 13px;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <div class="icon">🔐</div>
                <h2>Change Password</h2>
                <p>Enter your email and new password</p>
            </div>

            <div class="body">
                @if(session('success'))
                    <div class="alert alert-success">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        ⚠️
                        <ul style="margin-top: 5px; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <div class="form-group">
                        <label><i>📧</i> Email Address</label>
                        <input type="email" 
                               name="email" 
                               class="form-control" 
                               placeholder="admin@church.com" 
                               value="admin@church.com"
                               required>
                    </div>

                    <div class="form-group">
                        <label><i>🔒</i> New Password</label>
                        <input type="password" 
                               name="password" 
                               class="form-control" 
                               placeholder="Enter new password"
                               required>
                    </div>

                    <div class="form-group">
                        <label><i>🔒</i> Confirm Password</label>
                        <input type="password" 
                               name="password_confirmation" 
                               class="form-control" 
                               placeholder="Confirm new password"
                               required>
                    </div>

                    <button type="submit" class="btn">
                        🔄 Change Password
                    </button>

                    <div class="back-link">
                        <a href="{{ route('login') }}">← Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>