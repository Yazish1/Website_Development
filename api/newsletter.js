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
    const { email } = await req.json();
    
    // Here you would typically:
    // 1. Validate the email
    // 2. Store the email in your database
    // 3. Send a confirmation email
    
    return new Response(JSON.stringify({
      message: 'Newsletter subscription successful',
      email: email
    }), {
      status: 200,
      headers: { 'Content-Type': 'application/json' }
    });
  } catch (error) {
    return new Response(JSON.stringify({ error: 'Error processing subscription' }), {
      status: 500,
      headers: { 'Content-Type': 'application/json' }
    });
  }
} 