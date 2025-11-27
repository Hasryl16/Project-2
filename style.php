* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
    overflow-x: hidden;
}

/* Header & Navigation */
header {
    position: fixed;
    top: 0;
    width: 100%;
    background: transparent;
    opacity: 0.5;
    backdrop-filter: blur(10px);
    z-index: 1000;
    padding: 1rem 5%;
    /* box-shadow: 0 2px 10px rgba(0,0,0,0.1); */
}

nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1400px;
    margin: 0 auto;
}

.logo {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.3rem;
    font-weight: 700;
    color: #000;
}

.logo svg {
    width: 24px;
    height: 24px;
}

.nav-links {
    display: flex;
    gap: 2rem;
    list-style: none;
}

.nav-links a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    transition: color 0.3s;
}

.nav-links a:hover {
    color: #666;
}

.nav-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.search-box {
    padding: 0.5rem 1rem;
    border: 1px solid #ddd;
    border-radius: 20px;
    width: 200px;
}

.btn-primary {
    background: #000;
    color: #fff;
    padding: 0.7rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: background 0.3s;
}

.btn-primary:hover {
    background: #333;
}

/* Hero Section */
.hero {
    /* margin-top: 80px; */
    height: 100vh;
    max-width: 1400vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #fff;
    /* position: relative; */
    background: url('/asset/Hotel\ de\ lujo\ en\ Ibiza\,\ Santa\ Eulalia\ \(1\).jpeg')no-repeat;
    background-size: cover;
}

.hero-content {
    max-width: 800px;
    padding: 2rem;
}

.hero h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.hero p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

/* .hero-img {
    background-image: url('../asset/Hotel\ de\ lujo\ en\ Ibiza\,\ Santa\ Eulalia.jpeg');
} */

/* Search Form */
.search-form {
    background: #fff;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    max-width: 900px;
    margin: 0 auto;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    color: #333;
    font-weight: 600;
    font-size: 0.9rem;
}

.form-group select,
.form-group input {
    padding: 0.8rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    background: #f8f8f8;
}

.btn-search {
    grid-column: span 1;
    background: #000;
    color: #fff;
    padding: 1rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
    font-size: 1rem;
}

.btn-search:hover {
    background: #333;
}

/* Section Styles */
section {
    padding: 4rem 5%;
    max-width: 1400px;
    margin: 0 auto;
}

.section-title {
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 3rem;
    color: #000;
}

/* Hotel Cards */
.hotel-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

.hotel-card {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
}

.hotel-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.hotel-image {
    height: 200px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.hotel-image-2 {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.hotel-image-3 {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.hotel-image-4 {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.hotel-image::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);
}

.hotel-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: #fff;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 1;
}

.hotel-info {
    padding: 1.5rem;
}

.hotel-info h3 {
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
}

.hotel-info p {
    color: #666;
    margin-bottom: 1rem;
}

.hotel-price {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid #eee;
}

.price {
    font-size: 1.5rem;
    font-weight: 700;
    color: #000;
}

/* About Section */
.about-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: center;
}

.about-text h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.about-text p {
    color: #666;
    line-height: 1.8;
    margin-bottom: 1.5rem;
}

.about-image {
    height: 400px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
}

/* Features */
.features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.feature-card {
    text-align: center;
    padding: 2rem;
    background: #f8f8f8;
    border-radius: 15px;
    transition: transform 0.3s;
}

.feature-card:hover {
    transform: translateY(-5px);
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: #000;
    border-radius: 50%;
    margin: 0 auto 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.5rem;
}

.feature-card h3 {
    margin-bottom: 0.5rem;
}

.feature-card p {
    color: #666;
    font-size: 0.9rem;
}

/* Footer */
footer {
    background: #000;
    color: #fff;
    padding: 3rem 5%;
    margin-top: 4rem;
}

.footer-content {
    max-width: 1400px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.footer-section h3 {
    margin-bottom: 1rem;
}

.footer-section ul {
    list-style: none;
}

.footer-section a {
    color: #999;
    text-decoration: none;
    display: block;
    margin-bottom: 0.5rem;
    transition: color 0.3s;
}

.footer-section a:hover {
    color: #fff;
}

.footer-bottom {
    text-align: center;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #333;
    color: #999;
}

/* Responsive */
@media (max-width: 768px) {
    .hero h1 {
        font-size: 2rem;
    }

    .search-form {
        grid-template-columns: 1fr;
    }

    .about-content {
        grid-template-columns: 1fr;
    }

    .nav-links {
        display: none;
    }

    .search-box {
        display: none;
    }
}