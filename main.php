<?php

?>

<style>
  .heading-secondary,
.heading-primary,
.heading-tertiary {
  font-weight: 700;
  color: #333;
  letter-spacing: -0.5px;
}

.heading-primary {
  font-size: 3.2rem;
  line-height: 1.4;
  margin-bottom: 1.5rem;
}

.heading-secondary {
  font-size: 4.4rem;
  line-height: 1.2;
  margin-bottom: 9.6rem;
}

.heading-tertiary {
  font-size: 3rem;
  line-height: 1.2;
  margin-bottom: 3.2rem;
}

.subheading {
  display: block;
  font-size: 1.6rem;
  font-weight: 500;
  color: #cf711f;
  text-transform: uppercase;
  margin-bottom: 1.6rem;
  letter-spacing: 0.75px;
}

.hero {
  /* max-width: 130rem;
  width: 100%;
  height: 100vh;
  background-color: #eedbca;
  margin: 0 auto; 
  margin: 25px auto; */
  padding: 3rem 0;
  display: flex;
  gap: 10rem;
  align-items: center;
}

.hero-description {
  font-size: 18px;
  line-height: 1.5;
  margin-bottom: 1.9rem;
}

/* .hero-img {
  margin-top: 150px;
  margin-right: 100px;
  
} */

.students-enroll {
  display: flex;
  position: absolute;
  align-items: center;
  gap: 1.6rem;
  margin-top: 1rem;
}
.students-img {
  display: flex;
  align-items: center;
}

.students-img img {
  height: 3.2rem;
  width: 3.2rem;
  border-radius: 50%;
  margin-right: -1.6rem;
  border: 3px solid #fdf2e9;
}

.students-img img:last-child {
  margin: 0;
}

.enroll-text {
  margin-top: 15px;
  font-size: 1.5rem;
  font-weight: 600;
}

.enroll-text span {
  color: #cf711f;
  font-weight: 700;
}
.btn,
.btn:link,
.btn:visited {
  display: inline-block;

  text-decoration: none;
  font-size: 1.5rem;
  font-weight: 600;
  padding: 1rem 1.8rem;
  border-radius: 9px;

  /* only necessary for .btn */
  border: none;
  cursor: pointer;
  font-family: inherit;

  /* Put transition on orginal "state" */
  /* transition: background 0.3s; */
  transition: all 0.3s;
}

.btn--full:link,
.btn--full:visited {
  background-color: #e67e22;
  color: #fff;
}

.btn--full:hover,
.btn--full:active {
  background-color: #cf711f;
}

.btn--outline:link,
.btn--outline:visited {
  background-color: #fff;
  color: #555;
}

.btn--outline:hover,
.btn--outline:active {
  background-color: #fdf2e9;

  box-shadow: inset 0 0 0 3px #fff;
}

.margin-right-sm {
  margin-right: 2rem !important;
}


</style>
<link rel="stylesheet" href="css/card-list.css">
<main>
<div class="container">

      <div class="hero-section">
        <div class="hero">
          <div class="hero-text-box">
            <h1 class="heading-primary">
              Education is the most powerful weapon which you can use to change
              the world.
            </h1>
            <p class="hero-description">
              Embrace the opportunity for education every day of the year, for
              in the pursuit of knowledge, each day becomes a stepping stone to
              a brighter and more enlightened future.
            </p>
            <a href="#" class="btn btn--full margin-right-sm"
              >Start Learning
            </a>
            <a href="cources.php" class="btn btn--outline">Learn more &darr;</a>
            <br />
            <div class="students-enroll">
              <div class="students-img">
                <img src="img/students/AbhigyaSapkota.jpeg" alt="studentso" />
                <img src="img/students/BishalBhusal.jpeg" alt="students" />
                <img src="img/students/HimalDahal.jpeg" alt="students" />
                <img src="img/students/KushalAcharya.jpeg" alt="students" />
                <img src="img/students/RaghavPandey.jpeg" alt="students" />
                <img src="img/students/BipTech.jpg" alt="students" />
              </div>
              <p class="enroll-text">
                <span>250,000+</span> students enroll last months!
              </p>
            </div>
          </div>
          <div class="hero-img-box">
            <img src="img/icon/hero-image.png" alt="" class="hero-img" />
          </div>
        </div>
      </div>

      <h1 class = "booklists" id="booklists">Book Lists</h1>
      <div class="card-list">
        <a href="view_products.php" class="card-item">
          <img src="img/cart/cart (1).jpg" alt="Card Image" />
          <span class="developer">New Releases Book</span>
          <!-- <h3>
            New Releases" typically refers to recently published books that
            have recently become available to the public.
          </h3> -->
          <div class="arrow">
            <i class="fas fa-arrow-right card-icon"></i>
          </div>
        </a>
        <a href="view_products.php" class="card-item">
          <img src="img/cart/cart (1).jpeg" alt="Card Image" />
          <span class="designer">Audio Book</span>
          <!-- <h3>
            An audiobook is a recorded version of a book, allowing listeners to
            hear the content rather than read it.
          </h3> -->
          <div class="arrow">
            <i class="fas fa-arrow-right card-icon"></i>
          </div>
        </a>
        <a href="view_products.php" class="card-item">
          <img src="img/cart/cart (2).jpg" alt="Card Image" />
          <span class="editor">E-Book</span>
          <!-- <h3>
            An eBook is a digital or electronic version of a book that can be
            read on electronic devices such as eReaders, tablets, or computers.
          </h3> -->
          <div class="arrow">
            <i class="fas fa-arrow-right card-icon"></i>
          </div>
        </a>
      </div>
</div>
    </main>