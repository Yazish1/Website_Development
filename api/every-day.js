export default function handler(req, res) {
    // Your task logic here
    console.log("Cron job executed at:", new Date().toISOString());

    // Example task: Log a message
    res.status(200).json({ message: "Daily task executed successfully" });
}
