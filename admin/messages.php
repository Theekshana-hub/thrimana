<?php
require_once 'auth_check.php';

if (isset($_GET['read'])) {
    $id = $_GET['read'];
    $all = readJson('messages.json');
    foreach ($all as &$m) {
        if ($m['id'] == $id) { $m['is_read'] = 1; break; }
    }
    writeJson('messages.json', $all);
    header('Location: messages.php');
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $all = readJson('messages.json');
    $all = array_filter($all, function($m) use ($id) { return $m['id'] != $id; });
    writeJson('messages.json', array_values($all));
    header('Location: messages.php');
    exit;
}

$messages = getMessages();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | Thrimana Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'sidebar.php'; ?>
        <main class="admin-main">
            <header class="admin-header">
                <h1>Contact Messages</h1>
                <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </header>
            
            <div class="admin-card">
                <?php if (empty($messages)): ?>
                <p class="empty">No messages received yet.</p>
                <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email / Phone</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $m): ?>
                        <tr style="<?php echo empty($m['is_read']) ? 'background:rgba(245,184,0,0.05);' : ''; ?>">
                            <td>
                                <?php echo htmlspecialchars($m['name']); ?>
                                <?php if (empty($m['is_read'])): ?><span class="badge badge-new">New</span><?php endif; ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($m['email']); ?><br>
                                <small><?php echo htmlspecialchars($m['phone'] ?: '-'); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($m['subject'] ?: '-'); ?></td>
                            <td style="max-width:250px;"><?php echo nl2br(htmlspecialchars(substr($m['message'], 0, 120))); ?><?php echo strlen($m['message']) > 120 ? '...' : ''; ?></td>
                            <td><?php echo date('M d, Y H:i', strtotime($m['created_at'])); ?></td>
                            <td>
                                <?php if (empty($m['is_read'])): ?>
                                <a href="?read=<?php echo $m['id']; ?>" class="btn btn-sm btn-primary">Mark Read</a>
                                <?php endif; ?>
                                <a href="?delete=<?php echo $m['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
