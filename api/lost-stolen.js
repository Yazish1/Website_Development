// Import required modules
const { Pool } = require('pg');

// Create a new pool using environment variables
const pool = new Pool({
  host: process.env.DB_HOST,
  user: process.env.DB_USERNAME,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  port: process.env.DB_PORT || 5432,
  ssl: {
    rejectUnauthorized: false
  }
});

// Export the handler function
module.exports = async (req, res) => {
  // Set CORS headers
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'POST, OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');
  
  // Handle preflight requests
  if (req.method === 'OPTIONS') {
    res.status(200).end();
    return;
  }
  
  // Only allow POST requests
  if (req.method !== 'POST') {
    res.status(405).json({ error: 'Method not allowed' });
    return;
  }
  
  try {
    // Parse form data
    const formData = req.body;
    
    // Validate required fields
    if (!formData.roomnumber || !formData.description || !formData.time_incident || !formData.location || !formData.status) {
      res.status(400).json({ error: 'Missing required fields' });
      return;
    }
    
    // Validate status
    if (formData.status !== 'lost' && formData.status !== 'stolen') {
      res.status(400).json({ error: 'Invalid status. Must be either "lost" or "stolen".' });
      return;
    }
    
    // Insert data into database
    const query = `
      INSERT INTO lost_stolen_items 
      (room_number, item_description, time_incident, location, status) 
      VALUES ($1, $2, $3, $4, $5)
      RETURNING id
    `;
    
    const values = [
      formData.roomnumber,
      formData.description,
      formData.time_incident,
      formData.location,
      formData.status
    ];
    
    const result = await pool.query(query, values);
    
    // Return success response
    res.status(200).json({ 
      success: true, 
      message: 'Lost or stolen item report submitted successfully!',
      id: result.rows[0].id
    });
    
  } catch (error) {
    console.error('Error processing lost/stolen form:', error);
    res.status(500).json({ error: 'Database error: ' + error.message });
  }
}; 