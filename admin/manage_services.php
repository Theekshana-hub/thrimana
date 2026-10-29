<?php
require_once 'auth_check.php';
$success = '';
$error = '';

$uploadDir = dirname(__DIR__) . '/assets/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $all = readJson('services.json');
    if (!is_array($all)) $all = [];

    if ($action === 'add' || $action === 'edit') {
        $title = trim($_POST['title'] ?? '');
        $desc  = trim($_POST['description'] ?? '');
        $icon  = trim($_POST['icon'] ?? 'fa-tools');
        $imageName = '';

        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            if (in_array($ext, $allowed)) {
                $imageName = 'service_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
            } else {
                $error = 'Only JPG, PNG, WEBP, GIF allowed.';
            }
        }

        if ($title && empty($error)) {
            if ($action === 'add') {
                $maxId = 0;
                $maxOrder = 0;
                foreach ($all as $s) {
                    if (($s['id'] ?? 0) > $maxId) $maxId = $s['id'];
                    if (($s['sort_order'] ?? 0) > $maxOrder) $maxOrder = $s['sort_order'];
                }
                $all[] = [
                    'id' => $maxId + 1,
                    'title' => $title,
                    'description' => $desc,
                    'icon' => $icon,
                    'image' => $imageName,
                    'sort_order' => $maxOrder + 1,
                    'is_active' => 1
                ];
                writeJson('services.json', $all);
                $success = 'Service added successfully!';
            }

            if ($action === 'edit') {
                $id = (int)$_POST['id'];
                foreach ($all as &$s) {
                    if ($s['id'] == $id) {
                        $s['title'] = $title;
                        $s['description'] = $desc;
                        $s['icon'] = $icon;
                        if ($imageName) {
                            if (!empty($s['image']) && file_exists($uploadDir . $s['image'])) {
                                @unlink($uploadDir . $s['image']);
                            }
                            $s['image'] = $imageName;
                        }
                        break;
                    }
                }
                writeJson('services.json', $all);
                $success = 'Service updated!';
            }
        }
    }

    if ($action === 'delete') {
        $id = (int)$_POST['id'];
        foreach ($all as $s) {
            if ($s['id'] == $id && !empty($s['image']) && file_exists($uploadDir . $s['image'])) {
                @unlink($uploadDir . $s['image']);
            }
        }
        $all = array_values(array_filter($all, function($s) use ($id) {
            return ($s['id'] ?? 0) != $id;
        }));
        writeJson('services.json', $all);
        $success = 'Service deleted.';
    }

    if ($action === 'toggle') {
        $id = (int)$_POST['id'];
        foreach ($all as &$s) {
            if ($s['id'] == $id) {
                $s['is_active'] = empty($s['is_active']) ? 1 : 0;
                break;
            }
        }
        writeJson('services.json', $all);
        $success = 'Status updated.';
    }

    if ($action === 'remove_image') {
        $id = (int)$_POST['id'];
        foreach ($all as &$s) {
            if ($s['id'] == $id) {
                if (!empty($s['image']) && file_exists($uploadDir . $s['image'])) {
                    @unlink($uploadDir . $s['image']);
                }
                $s['image'] = '';
                break;
            }
        }
        writeJson('services.json', $all);
        $success = 'Image removed.';
    }
}

$services = readJson('services.json');
if (!is_array($services)) $services = [];
usort($services, function($a, $b) {
    return ($a['sort_order'] ?? 0) <=> ($b['sort_order'] ?? 0);
});

$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editItem = null;
foreach ($services as $s) {
    if (($s['id'] ?? 0) == $editId) {
        $editItem = $s;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services | Thrimana Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'sidebar.php'; ?>
        <main class="admin-main">
            <header class="admin-header">
                <h1>Manage Services</h1>
                <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </header>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="admin-card">
                <h2><?php echo $editItem ? 'Edit Service' : 'Add New Service'; ?></h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?php echo $editItem ? 'edit' : 'add'; ?>">
                    <?php if ($editItem): ?>
                        <input type="hidden" name="id" value="<?php echo $editItem['id']; ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" required value="<?php echo htmlspecialchars($editItem['title'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3"><?php echo htmlspecialchars($editItem['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Icon (Font Awesome class, e.g. fa-industry)</label>
                        <input type="text" name="icon" value="<?php echo htmlspecialchars($editItem['icon'] ?? 'fa-tools'); ?>">
                    </div>
                    <div class="form-group">
                        <label>Service Image (optional)</label>
                        <input type="file" name="image" accept="image/*">
                        <?php if (!empty($editItem['image'])): ?>
                            <div style="margin-top:12px;">
                                <img src="../assets/uploads/<?php echo htmlspecialchars($editItem['image']); ?>"
                                     style="max-width:180px;border-radius:8px;border:1px solid #333;">
                                <br>
                                <button type="submit" name="action" value="remove_image" class="btn btn-sm btn-danger" style="margin-top:8px;">
                                    Remove Image
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?php echo $editItem ? 'Update' : 'Add Service'; ?>
                    </button>
                    <?php if ($editItem): ?>
                        <a href="manage_services.php" class="btn" style="background:#333;color:#fff;margin-left:10px;">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="admin-card">
                <h2>All Services (Admin Added)</h2>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($services)): ?>
                            <tr>
                                <td colspan="5" style="text-align:center;color:#888;">No services added yet from admin.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($services as $s): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($s['image'])): ?>
                                        <img src="../assets/uploads/<?php echo htmlspecialchars($s['image']); ?>"
                                             style="width:60px;height:40px;object-fit:cover;border-radius:4px;">
                                    <?php else: ?>
                                        <span style="color:#666;">No image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($s['title']); ?></td>
                                <td><i class="fas <?php echo htmlspecialchars($s['icon'] ?? 'fa-tools'); ?>"></i> <?php echo $s['icon'] ?? ''; ?></td>
                                <td>
                                    <?php echo !empty($s['is_active'])
                                        ? '<span class="badge badge-new">Active</span>'
                                        : '<span class="badge badge-read">Hidden</span>'; ?>
                                </td>
                                <td>
                                    <a href="?edit=<?php echo $s['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this service?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="action" value="toggle">
                                        <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                                        <button type="submit" class="btn btn-sm" style="background:#333;color:#ccc;">Toggle</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>