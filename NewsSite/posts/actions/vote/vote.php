<?php
session_start();

require_once dirname(__FILE__).'/../../../mysql/database.php';

$isLoggedIn = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : false;
if (!$isLoggedIn) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit();
}

if (!hash_equals($_SESSION['token'], $_POST['token'])) {
    die("Request forgery detected");
}

$userId = $_SESSION["user_id"];
$storyId = (int)$_POST['story_id'];
$voteValue = (int)$_POST['vote_value'];

if ($voteValue !== 1 && $voteValue !== -1) {
    echo json_encode(['error' => 'Invalid vote value']);
    exit();
}

$stmt = $mysqli->prepare("SELECT vote_value FROM votes WHERE user_id = ? AND story_id = ?");
$stmt->bind_param("ii", $userId, $storyId);
$stmt->execute();
$stmt->store_result();
$existingVote = null;

if ($stmt->num_rows > 0) {
    $stmt->bind_result($existingVote);
    $stmt->fetch();
}
$stmt->close();

if ($existingVote === $voteValue) {
    $stmt = $mysqli->prepare("DELETE FROM votes WHERE user_id = ? AND story_id = ?");
    $stmt->bind_param("ii", $userId, $storyId);
    $stmt->execute();
    $stmt->close();
    
    $change = -$voteValue;
} elseif ($existingVote !== null) {
    $stmt = $mysqli->prepare("UPDATE votes SET vote_value = ? WHERE user_id = ? AND story_id = ?");
    $stmt->bind_param("iii", $voteValue, $userId, $storyId);
    $stmt->execute();
    $stmt->close();
    
    $change = $voteValue * 2;
} else {
    $stmt = $mysqli->prepare("INSERT INTO votes (user_id, story_id, vote_value) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $userId, $storyId, $voteValue);
    $stmt->execute();
    $stmt->close();
    
    $change = $voteValue;
}

$stmt = $mysqli->prepare("UPDATE posts SET vote_count = vote_count + ? WHERE id = ?");
$stmt->bind_param("ii", $change, $storyId);
$stmt->execute();
$stmt->close();

$stmt = $mysqli->prepare("SELECT vote_count FROM posts WHERE id = ?");
$stmt->bind_param("i", $storyId);
$stmt->execute();
$stmt->bind_result($newCount);
$stmt->fetch();
$stmt->close();

echo json_encode([
    'success' => true,
    'vote_count' => $newCount,
    'user_vote' => ($existingVote === $voteValue) ? 0 : $voteValue
]);

header("Location: {$_SERVER['HTTP_REFERER']}"); exit;
?>
