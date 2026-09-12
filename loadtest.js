import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
  stages: [
    { duration: '10s', target: 10 },  // 10 sec mein 10 users
    { duration: '30s', target: 50 },  // 30 sec tak 50 users (Peak Load)
    { duration: '10s', target: 0 },   // 10 sec mein ramp down
  ],
};

export default function () {
  // Apka local server URL (e.g. php artisan serve ka URL)
  const url = 'http://127.0.0.1:8000'; 

  const res = http.get(url);

  check(res, {
    'status 200': (r) => r.status === 200,
  });

  sleep(1);
}