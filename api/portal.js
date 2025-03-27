export const config = {
  runtime: 'edge',
};

export default async function handler(req) {
  if (req.method !== 'POST') {
    return new Response(JSON.stringify({ error: 'Method not allowed' }), {
      status: 405,
      headers: { 'Content-Type': 'application/json' }
    });
  }

  try {
    const { roomNumber, password } = await req.json();
    
    // Here you would typically:
    // 1. Validate the room number and password
    // 2. Check against your database
    // 3. Generate access tokens if valid
    
    return new Response(JSON.stringify({
      message: 'Portal access request processed',
      roomNumber: roomNumber
    }), {
      status: 200,
      headers: { 'Content-Type': 'application/json' }
    });
  } catch (error) {
    return new Response(JSON.stringify({ error: 'Error processing portal request' }), {
      status: 500,
      headers: { 'Content-Type': 'application/json' }
    });
  }
} 