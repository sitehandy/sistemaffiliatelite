# Landing Pages

Static HTML/JavaScript landing pages for the affiliate system.

## Files

### index.html

Main landing page to attract and convert potential affiliates.

**Features:**
- Fully responsive design (mobile, tablet, desktop)
- Modern UI with Tailwind CSS
- Smooth animations and transitions
- FAQ accordion
- Testimonials section
- Commission structure showcase
- Call-to-action sections

**Sections:**
1. Hero - Main headline with stats preview
2. Stats - Key metrics (affiliates, payouts, products, commission)
3. Features - 6 key features with icons
4. How It Works - 3-step process
5. Commission Structure - Pay per Sale/Lead/View cards
6. Testimonials - 3 affiliate testimonials
7. FAQ - 5 common questions with accordion
8. CTA - Final call to action
9. Footer - Links and social media

## Usage

### Option 1: Direct Access
Place the landing-pages folder in your public directory and access directly:
```
https://yourdomain.com/landing-pages/
```

### Option 2: Laravel Route
Add a route to serve the landing page:

```php
// routes/web.php
Route::get('/affiliate-program', function () {
    return file_get_contents(base_path('landing-pages/index.html'));
});
```

### Option 3: Custom Domain
Point a subdomain (e.g., `join.yourdomain.com`) to the landing-pages folder.

## Customization

### Change Branding
1. Update the logo and brand name in the navigation and footer
2. Modify the primary color in Tailwind config:
   ```javascript
   tailwind.config = {
       theme: {
           extend: {
               colors: {
                   primary: '#your-color',
                   secondary: '#your-color',
               }
           }
       }
   }
   ```

### Update Content
- Edit testimonials with real affiliate feedback
- Update statistics with actual numbers
- Modify commission rates to match your programs
- Add/remove FAQ items as needed

### Links
Update these links to match your routes:
- `/login` - Login page
- `/register` - Registration page
- `/help` - Help center
- `/contact` - Contact page
- `/terms` - Terms of service
- `/privacy` - Privacy policy

## Dependencies

- Tailwind CSS (CDN)
- No other external dependencies

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers
