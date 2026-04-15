<?php
require "includes/connect.php";
require "includes/auth.php";



// create query for all member info sorted by id number
$sql = "SELECT id, photo_name, photo
        FROM photo_storage
        ORDER BY id DESC";

// prepare
$stmt = $pdo->prepare($sql);

// execute
$stmt->execute();

// retrieve all rows returned by a SQL query at once
$pictures = $stmt->fetchAll();
?>

            <h2 class="fw-bold text-light">PHOTO GALLERY</h2>
            <a href="add.php" class="btn btn-warning mb-5">+ Add Photo</a>

            <?php if (count($pictures) === 0): ?>
                <p class="text-light">No photos yet! Click <strong>+ Add Photo</strong> to add.</p>
            <?php else: ?>

                <!-- table to show photos-->
                        <table >
                            <thead>
                                <tr>
                                    
                                    <th>Image Name</th>
                                    <th>Photo</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- loop through each picutre -->
                                <?php foreach ($pictures as $picture): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($picture["photo_name"]) ?></td>
                                        <td>
                                            <!-- display uploaded player photo if it exists -->
                                            <?php if (!empty($picture["photo"])): ?>
                                                <img src="uploads/<?= htmlspecialchars($picture["photo"]) ?>" alt="Photo" width="80">
                                            <?php else: ?>
                                                No Photo
                                            <?php endif; ?>
                                        </td>
                                        <td >
                                            <a href="delete.php?id=<?= $picture["id"] ?>"
                                                onclick="return confirm('Delete this photo?');">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
            <?php endif; ?>


