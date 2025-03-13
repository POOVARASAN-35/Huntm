<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1000px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            color: #333;
            font-weight: bold;
        }
        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }
        .table td {
            text-align: center;
            vertical-align: middle;
            padding: 10px;
        }
        .password-hidden {
            font-size: 1.2rem;
            font-weight: bold;
            letter-spacing: 5px;
            color: #555;
        }
        .truncate-url {
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
            vertical-align: middle;
        }
        .btn-copy {
            background: none;
            border: none;
            cursor: pointer;
            color: #007bff;
            font-size: 14px;
        }
        .btn-copy:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">🌐 Website Credentials Dashboard</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>User ID</th>
                    <th>Password</th>
                    <th>Website URL</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($websites)) : ?>
                    <?php foreach ($websites as $index => $website) : ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($website['website_userId'] ?? 'N/A'); ?></td>
                            <td class="password-hidden">****</td> 
                            <td>
                                <?php if (!empty($website['website_url'])) : ?>
                                    <a href="<?= htmlspecialchars($website['website_url']); ?>" target="_blank" class="truncate-url" title="<?= htmlspecialchars($website['website_url']); ?>">
                                        <?= htmlspecialchars($website['website_url']); ?>
                                    </a>
                                    <button class="btn-copy" onclick="copyToClipboard('<?= htmlspecialchars($website['website_url']); ?>')">
                                        📋 Copy
                                    </button>
                                <?php else : ?>
                                    N/A
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($website['website_url'])) : ?>
                                    <a href="<?= htmlspecialchars($website['website_url']); ?>" target="_blank" class="btn btn-primary">🔗 Login</a>
                                <?php else : ?>
                                    <button class="btn btn-secondary" disabled>No URL</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="5" class="text-center">No data available</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function copyToClipboard(url) {
            navigator.clipboard.writeText(url).then(() => {
                alert("URL copied to clipboard!");
            }).catch(err => {
                console.error("Failed to copy:", err);
            });
        }
    </script>
</body>
</html>