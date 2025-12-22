@extends('frontend.app')
@section('title', 'Dashboard')
@section('pagetitle', 'Dashboard')

<!DOCTYPE html>
<html lang="en">
<head>
  <title>iUniversity</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="author" content="TemplatesJungle">
  <meta name="keywords" content="Online Store">
  <meta name="description" content="">
  <link rel="stylesheet" href="css/vendor.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/all.min.css">
  <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
  <link rel="stylesheet" type="text/css" href="css/intlTelInput.css">
</head>

<body>
  <header id="header" class="site-header text-black">
    <div class="header-top py-2">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-4">
            <div class="d-flex items-center">
              <a class="position-relative logo me-4" href="#">
                <img alt="iUniversity-logo" src="images/i-university-logo-01.png">
              </a>
              <div class="search-box position-relative d-flex items-center">
                <input type="search" placeholder="Explore Courses"
                  class="outline-none border border-rounded-10 ps-3 pe-4 py-2 d-flex bg-white" value="">
                <div class="search-wrap position-absolute">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="d-flex justify-content-end">
              <div class="navbar-block" id="menu">
                <ul class="menu">
                  <li class="menu-item dropdown">
                    <span class="dropdown-toggle menu-link">
                      For working Professionals <i class="bx bx-chevron-down"></i>
                    </span>
                    <div class="dropdown-content">
                      <div class="container">
                        <div class="row">
                          <div class="col-lg-3">
                            <div class="left-tab">
                              <h4><i class="fa-solid fa-list me-3"></i> Domains</h4>
                              <div class="nav flex-column nav-pills me-3 menu-tab" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <button class="nav-link active" id="v-doctorate-tab" data-bs-toggle="pill"
                                  data-bs-target="#v-doctorate" type="button" role="tab" aria-controls="v-doctorate"
                                  aria-selected="true">Doctorate <i class="fa-solid fa-chevron-right"></i></button>
                                <button class="nav-link" id="v-AIML-tab" data-bs-toggle="pill" data-bs-target="#v-AIML"
                                  type="button" role="tab" aria-controls="v-AIML" aria-selected="false">AI & ML <i
                                    class="fa-solid fa-chevron-right"></i></button>
                                <button class="nav-link" id="v-MBABBA-tab" data-bs-toggle="pill"
                                  data-bs-target="#v-MBABBA" type="button" role="tab" aria-controls="v-MBABBA"
                                  aria-selected="false">MBA/BBA <i class="fa-solid fa-chevron-right"></i></button>
                                <button class="nav-link" id="v-datascience-tab" data-bs-toggle="pill"
                                  data-bs-target="#v-datascience" type="button" role="tab" aria-controls="v-datascience"
                                  aria-selected="false">Data Science <i class="fa-solid fa-chevron-right"></i></button>
                                <button class="nav-link" id="v-datascience-tab" data-bs-toggle="pill"
                                  data-bs-target="#v-datascience" type="button" role="tab" aria-controls="v-datascience"
                                  aria-selected="false">Marketing <i class="fa-solid fa-chevron-right"></i></button>
                                <button class="nav-link" id="v-datascience-tab" data-bs-toggle="pill"
                                  data-bs-target="#v-datascience" type="button" role="tab" aria-controls="v-datascience"
                                  aria-selected="false">Management <i class="fa-solid fa-chevron-right"></i></button>
                                <button class="nav-link" id="v-datascience-tab" data-bs-toggle="pill"
                                  data-bs-target="#v-datascience" type="button" role="tab" aria-controls="v-datascience"
                                  aria-selected="false">Software & Tech <i
                                    class="fa-solid fa-chevron-right"></i></button>
                                <button class="nav-link" id="v-datascience-tab" data-bs-toggle="pill"
                                  data-bs-target="#v-datascience" type="button" role="tab" aria-controls="v-datascience"
                                  aria-selected="false">Laws <i class="fa-solid fa-chevron-right"></i></button>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-9">
                            <div class="right-tab">
                              <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-doctorate" role="tabpanel"
                                  aria-labelledby="v-doctorate-tab">
                                  <div class="d-flex justify-content-between">
                                    <h4> Doctorate </h4>
                                    <div class="view-all-btn"><a href="#">View All</a><i
                                        class="fa-solid fa-chevron-right"></i></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-4">
                                      <h6> For All Domains </h6>
                                      <ul class="mega-menu-list">
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                      </ul>
                                    </div>
                                    <div class="col-lg-4">
                                      <h6> Leadership / AI </h6>
                                      <ul class="mega-menu-list">
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="tab-pane fade" id="v-AIML" role="tabpanel" aria-labelledby="v-AIML-tab">
                                  <div class="d-flex justify-content-between">
                                    <h4> Ai & ML </h4>
                                    <div class="view-all-btn"><a href="#">View All</a><i
                                        class="fa-solid fa-chevron-right"></i></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-4">
                                      <h6> Degree / Exec. PG </h6>
                                      <ul class="mega-menu-list">
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                      </ul>
                                    </div>
                                    <div class="col-lg-4">
                                      <h6> Leadership / AI </h6>
                                      <ul class="mega-menu-list">
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>


                                </div>
                                <div class="tab-pane fade" id="v-MBABBA" role="tabpanel" aria-labelledby="v-MBABBA-tab">
                                  <div class="d-flex justify-content-between">
                                    <h4> MBA/BBA </h4>
                                    <div class="view-all-btn"><a href="#">View All</a><i
                                        class="fa-solid fa-chevron-right"></i></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-4">
                                      <h6> For All Domains </h6>
                                      <ul class="mega-menu-list">
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                      </ul>
                                    </div>
                                    <div class="col-lg-4">
                                      <h6> Leadership / AI </h6>
                                      <ul class="mega-menu-list">
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="tab-pane fade" id="v-datascience" role="tabpanel"
                                  aria-labelledby="v-datascience-tab">
                                  <div class="d-flex justify-content-between">
                                    <h4> Data Science </h4>
                                    <div class="view-all-btn"><a href="#">View All</a><i
                                        class="fa-solid fa-chevron-right"></i></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-4">
                                      <h6> For All Domains </h6>
                                      <ul class="mega-menu-list">
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                      </ul>
                                    </div>
                                    <div class="col-lg-4">
                                      <h6> Leadership / AI </h6>
                                      <ul class="mega-menu-list">
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <div class="d-flex align-items-start g-2">
                                              <img src="images/MegaMenu/ESGCI.svg" />
                                              <span class="d-flex flex-column g-2">
                                                <p class="text-gray fw-bold">ESGCI</p>
                                                <p class="text-dark">Doctorate of Business Administration (DBA) from
                                                  ESGCI, Paris </p>
                                              </span>
                                            </div>
                                          </a>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>

                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="menu-item dropdown">
                    <span class="dropdown-toggle menu-link">
                      For College Students <i class="bx bx-chevron-down"></i>
                    </span>
                    <div class="dropdown-content">
                      <div class="dropdown-column">
                        <div class="dropdown-group">
                          <div class="dropdown-block">
                            <span class="dropdown-icon"><i class="bx bx-podcast"></i></span>
                            <div class="dropdown-inner">
                              <a href="#" class="text-base font-medium">Podcasts</a>
                              <p class="text-base font-normal">
                                Hear and enjoy our inspiration podcast together with us.
                              </p>
                            </div>
                          </div>
                          <div class="dropdown-block">
                            <span class="dropdown-icon"><i class="bx bx-video"></i></span>
                            <div class="dropdown-inner">
                              <a href="#" class="text-base font-medium">Tutorials</a>
                              <p class="text-base font-normal">
                                Learn video tutorial with our professional instructors.
                              </p>
                            </div>
                          </div>
                        </div>
                        <div class="dropdown-group">
                          <div class="dropdown-block">
                            <span class="dropdown-icon"><i class="bx bx-book-open"></i></span>
                            <div class="dropdown-inner">
                              <a href="#" class="text-base font-medium">Help Center</a>
                              <p class="text-base font-normal">
                                Discover how to register, install and use our products.
                              </p>
                            </div>
                          </div>
                          <div class="dropdown-block">
                            <span class="dropdown-icon"><i class="bx bx-bookmark"></i></span>
                            <div class="dropdown-inner">
                              <a href="#" class="text-base font-medium">Community</a>
                              <p class="text-base font-normal">
                                Share and connect with other user in our communities.
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="menu-item dropdown">
                    <span class="dropdown-toggle menu-link">
                      Study Abroad <i class="bx bx-chevron-down"></i>
                    </span>
                    <div class="dropdown-content">
                      <div class="dropdown-column">
                        <div class="dropdown-group">
                          <div class="dropdown-block">
                            <span class="dropdown-icon"><i class="bx bx-podcast"></i></span>
                            <div class="dropdown-inner">
                              <a href="#" class="text-base font-medium">Podcasts</a>
                              <p class="text-base font-normal">
                                Hear and enjoy our inspiration podcast together with us.
                              </p>
                            </div>
                          </div>
                          <div class="dropdown-block">
                            <span class="dropdown-icon"><i class="bx bx-video"></i></span>
                            <div class="dropdown-inner">
                              <a href="#" class="text-base font-medium">Tutorials</a>
                              <p class="text-base font-normal">
                                Learn video tutorial with our professional instructors.
                              </p>
                            </div>
                          </div>
                        </div>
                        <div class="dropdown-group">
                          <div class="dropdown-block">
                            <span class="dropdown-icon"><i class="bx bx-book-open"></i></span>
                            <div class="dropdown-inner">
                              <a href="#" class="text-base font-medium">Help Center</a>
                              <p class="text-base font-normal">
                                Discover how to register, install and use our products.
                              </p>
                            </div>
                          </div>
                          <div class="dropdown-block">
                            <span class="dropdown-icon"><i class="bx bx-bookmark"></i></span>
                            <div class="dropdown-inner">
                              <a href="#" class="text-base font-medium">Community</a>
                              <p class="text-base font-normal">
                                Share and connect with other user in our communities.
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="menu-item dropdown">
                    <span class="dropdown-toggle menu-link">
                      More <i class="bx bx-chevron-down"></i>
                    </span>
                    <div class="dropdown-content">
                      <div class="container">
                        <div class="right-tab">
                          <div class="row">
                            <div class="col-lg-3">
                              <h6> For All Domains </h6>
                              <ul class="mega-menu-list">
                                <li>
                                  <a href="#">
                                    <div class="d-flex align-items-start g-2">

                                      <span class="d-flex flex-column g-2">
                                        <p class="text-gray fw-bold">ESGCI</p>
                                        <p class="text-dark">Doctorate of Business Administration (DBA) from ESGCI,
                                          Paris </p>
                                      </span>
                                    </div>
                                  </a>
                                </li>
                                <li>
                                  <a href="#">
                                    <div class="d-flex align-items-start g-2">

                                      <span class="d-flex flex-column g-2">
                                        <p class="text-gray fw-bold">ESGCI</p>
                                        <p class="text-dark">Doctorate of Business Administration (DBA) from ESGCI,
                                          Paris </p>
                                      </span>
                                    </div>
                                  </a>
                                </li>
                                <li>
                                  <a href="#">
                                    <div class="d-flex align-items-start g-2">

                                      <span class="d-flex flex-column g-2">
                                        <p class="text-gray fw-bold">ESGCI</p>
                                        <p class="text-dark">Doctorate of Business Administration (DBA) from ESGCI,
                                          Paris </p>
                                      </span>
                                    </div>
                                  </a>
                                </li>
                                <li>
                                  <a href="#">
                                    <div class="d-flex align-items-start g-2">

                                      <span class="d-flex flex-column g-2">
                                        <p class="text-gray fw-bold">ESGCI</p>
                                        <p class="text-dark">Doctorate of Business Administration (DBA) from ESGCI,
                                          Paris </p>
                                      </span>
                                    </div>
                                  </a>
                                </li>
                              </ul>
                            </div>
                            <div class="col-lg-3">
                              <h6> Leadership / AI </h6>
                              <ul class="mega-menu-list">
                                <li>
                                  <a href="#">
                                    <div class="d-flex align-items-start g-2">

                                      <span class="d-flex flex-column g-2">
                                        <p class="text-gray fw-bold">ESGCI</p>
                                        <p class="text-dark">Doctorate of Business Administration (DBA) from ESGCI,
                                          Paris </p>
                                      </span>
                                    </div>
                                  </a>
                                </li>
                                <li>
                                  <a href="#">
                                    <div class="d-flex align-items-start g-2">

                                      <span class="d-flex flex-column g-2">
                                        <p class="text-gray fw-bold">ESGCI</p>
                                        <p class="text-dark">Doctorate of Business Administration (DBA) from ESGCI,
                                          Paris </p>
                                      </span>
                                    </div>
                                  </a>
                                </li>
                                <li>
                                  <a href="#">
                                    <div class="d-flex align-items-start g-2">

                                      <span class="d-flex flex-column g-2">
                                        <p class="text-gray fw-bold">ESGCI</p>
                                        <p class="text-dark">Doctorate of Business Administration (DBA) from ESGCI,
                                          Paris </p>
                                      </span>
                                    </div>
                                  </a>
                                </li>
                                <li>
                                  <a href="#">
                                    <div class="d-flex align-items-start g-2">

                                      <span class="d-flex flex-column g-2">
                                        <p class="text-gray fw-bold">ESGCI</p>
                                        <p class="text-dark">Doctorate of Business Administration (DBA) from ESGCI,
                                          Paris </p>
                                      </span>
                                    </div>
                                  </a>
                                </li>
                              </ul>
                            </div>
                            <div class="col-lg-3">
                              <h6> Leadership / AI </h6>
                              <ul class="mega-menu-list">
                                <li>
                                  <a href="#">
                                    <div class="d-flex align-items-start g-2">

                                      <span class="d-flex flex-column g-2">
                                        <p class="text-gray fw-bold">ESGCI</p>
                                        <p class="text-dark">Doctorate of Business Administration (DBA) from ESGCI,
                                          Paris </p>
                                      </span>
                                    </div>
                                  </a>
                                </li>
                                <li>
                                  <a href="#">
                                    <div class="d-flex align-items-start g-2">

                                      <span class="d-flex flex-column g-2">
                                        <p class="text-gray fw-bold">ESGCI</p>
                                        <p class="text-dark">Doctorate of Business Administration (DBA) from ESGCI,
                                          Paris </p>
                                      </span>
                                    </div>
                                  </a>
                                </li>
                                <li>
                                  <a href="#">
                                    <div class="d-flex align-items-start g-2">

                                      <span class="d-flex flex-column g-2">
                                        <p class="text-gray fw-bold">ESGCI</p>
                                        <p class="text-dark">Doctorate of Business Administration (DBA) from ESGCI,
                                          Paris </p>
                                      </span>
                                    </div>
                                  </a>
                                </li>
                                <li>
                                  <a href="#">
                                    <div class="d-flex align-items-start g-2">

                                      <span class="d-flex flex-column g-2">
                                        <p class="text-gray fw-bold">ESGCI</p>
                                        <p class="text-dark">Doctorate of Business Administration (DBA) from ESGCI,
                                          Paris </p>
                                      </span>
                                    </div>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="d-flex items-center">
                <a class="btn-free me-2" target="_blank" href="#"> Free Courses </a>
                <button class="btn-login" data-bs-toggle="modal" data-bs-target="#signup"> Sign Up </button>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>
    <!-- Signup -->
    <div class="modal fade signupSheet" id="signup" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
      tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6 leftsheet">
                <img src="images/login/signup.svg" class="img-fluid">
                <a href="#" class="btnLogin promotionBtn"> <svg width="20" height="20" viewBox="0 0 23 23" fill="none"
                    xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                    <title>Promotion</title>
                    <path
                      d="M15.5189 15.0943V18.4025H17.173V15.0943H18.8271L16.346 12.6132L13.8648 15.0943H15.5189ZM10.5567 4.34277C8.73718 4.34277 7.24851 5.83145 7.24851 7.65093C7.24851 9.47042 8.73718 10.9591 10.5567 10.9591C12.3762 10.9591 13.8648 9.47042 13.8648 7.65093C13.8648 5.83145 12.3762 4.34277 10.5567 4.34277ZM10.5567 12.6132C6.9177 12.6132 3.94035 14.1018 3.94035 15.9213V17.5754H11.7972C11.5491 16.9138 11.3837 16.2522 11.3837 15.5078C11.3837 14.5154 11.6318 13.6056 12.1281 12.6959C11.6318 12.6959 11.1356 12.6132 10.5567 12.6132Z"
                      fill="currentColor"></path>
                  </svg> Promotion</a>
                <a href="#" class="btnLogin switchBtn"> <svg width="20" height="20" viewBox="0 0 23 23" fill="none"
                    xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                    <title>Career Switch</title>
                    <path
                      d="M19.8146 9.03172L16.1901 5.40723V8.1256H9.84726V9.93785H16.1901V12.6562M7.12889 10.844L3.50439 14.4685L7.12889 18.093V15.3746H13.4718V13.5623H7.12889V10.844Z"
                      fill="currentColor"></path>
                  </svg> Career Switch</a>
                <a href="#" class="btnLogin hikeBtn"> <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                    <title>Salary Hike</title>
                    <mask id="mask0_271_6453" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24"
                      style="mask-type: alpha;">
                      <rect width="24" height="24" fill="#D9D9D9"></rect>
                    </mask>
                    <g mask="url(#mask0_271_6453)">
                      <path d="M3.4 18L2 16.6L9.4 9.15L13.4 13.15L18.6 8H16V6H22V12H20V9.4L13.4 16L9.4 12L3.4 18Z"
                        fill="currentColor"></path>
                    </g>
                  </svg> Salary Hike</a>
              </div>
              <div class="col-lg-6 rightSheet">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <form>
                  <h5 class="modal-title" id="exampleModalToggleLabel">Welcome! Sign up or Login</h5>
                  <div class="form-group" id="phoneLogin">
                    <input type="tel" id="mobile_code" class="form-control" placeholder="Phone Number" name="phone"
                      pattern="(\d{10})|(^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$)">
                  </div>
                  <div class="form-group d-none" id="emailLogin">
                    <input type="email" id="email" autocomplete="off" required>
                    <label for="email">Email Address</label>
                  </div>
                  <span class="or-type">or</span>
                  <button type="button" class="emailToggle">Continue with Email</button>
                  <div class="modal-footer">
                    <button class="btn btn-primary" id="btnSubmit" data-bs-target="#OtpPage" data-bs-toggle="modal"
                      data-bs-dismiss="modal" disabled>Continue</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade signupSheet" id="OtpPage" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
      tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="row">
            <div class="col-lg-6 leftsheet">
              <img src="images/login/signup.svg" class="img-fluid">
              <a href="#" class="btnLogin promotionBtn"> <svg width="20" height="20" viewBox="0 0 23 23" fill="none"
                  xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                  <title>Promotion</title>
                  <path
                    d="M15.5189 15.0943V18.4025H17.173V15.0943H18.8271L16.346 12.6132L13.8648 15.0943H15.5189ZM10.5567 4.34277C8.73718 4.34277 7.24851 5.83145 7.24851 7.65093C7.24851 9.47042 8.73718 10.9591 10.5567 10.9591C12.3762 10.9591 13.8648 9.47042 13.8648 7.65093C13.8648 5.83145 12.3762 4.34277 10.5567 4.34277ZM10.5567 12.6132C6.9177 12.6132 3.94035 14.1018 3.94035 15.9213V17.5754H11.7972C11.5491 16.9138 11.3837 16.2522 11.3837 15.5078C11.3837 14.5154 11.6318 13.6056 12.1281 12.6959C11.6318 12.6959 11.1356 12.6132 10.5567 12.6132Z"
                    fill="currentColor"></path>
                </svg> Promotion</a>
              <a href="#" class="btnLogin switchBtn"> <svg width="20" height="20" viewBox="0 0 23 23" fill="none"
                  xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                  <title>Career Switch</title>
                  <path
                    d="M19.8146 9.03172L16.1901 5.40723V8.1256H9.84726V9.93785H16.1901V12.6562M7.12889 10.844L3.50439 14.4685L7.12889 18.093V15.3746H13.4718V13.5623H7.12889V10.844Z"
                    fill="currentColor"></path>
                </svg> Career Switch</a>
              <a href="#" class="btnLogin hikeBtn"> <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                  xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                  <title>Salary Hike</title>
                  <mask id="mask0_271_6453" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24"
                    style="mask-type: alpha;">
                    <rect width="24" height="24" fill="#D9D9D9"></rect>
                  </mask>
                  <g mask="url(#mask0_271_6453)">
                    <path d="M3.4 18L2 16.6L9.4 9.15L13.4 13.15L18.6 8H16V6H22V12H20V9.4L13.4 16L9.4 12L3.4 18Z"
                      fill="currentColor"></path>
                  </g>
                </svg> Salary Hike</a>
            </div>
            <div class="col-lg-6 rightSheet text-start">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <form class="otp-event align-items-start">
                <a href="#" data-bs-target="#signup" data-bs-toggle="modal" data-bs-dismiss="modal"><i
                    class="fa-solid fa-arrow-left-long"></i> </a>
                <h5 class="modal-title mb-0" id="exampleModalToggleLabel">We've sent an OTP on</h5>
                <p> +91 1234567890 <a href="#"> Edit </a></p>
                <div class="otpCover">
                  <input type="tel" id="otp-number-input-1" placeholder="-" class="otp-number-input" maxlength="1"
                    autocomplete="off">
                  <input type="tel" id="otp-number-input-2" placeholder="-" class="otp-number-input" maxlength="1"
                    autocomplete="off">
                  <input type="tel" id="otp-number-input-3" placeholder="-" class="otp-number-input" maxlength="1"
                    autocomplete="off">
                  <input type="tel" id="otp-number-input-4" placeholder="-" class="otp-number-input" maxlength="1"
                    autocomplete="off">
                </div>
                <div class="d-flex">
                  <p class="me-2">Didn't receive OTP?</p>
                  <p id="verifiBtn" class="or-type"> Resend in <span id="counter"></span> </p>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-primary otp-submit" disabled>Continue</button>
                </div>
              </form>




            </div>
          </div>


        </div>
      </div>
    </div>

    <!-- Signup -->

  </header>

  <section class="breadcrumb-banner">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Library</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <section class="p-0">
    <div class="container">
      <div class="row g-0">
        <div class="col-lg-7">
          <div class="leftProgramme">
            <a href="#" class="shareBtn"> <i class="fa-solid fa-share-nodes"></i> </a>
            <h1 class="">
              <span class="text-primary-main">Doctorate of Business Administration</span> (DBA) from ESGCI¹, Paris
            </h1>
            <p>Enroll in this unique DBA program, designed for leaders to reach their potential.
              Focused on leadership, global immersion,&amp; personalized guidance, it equips you with skills to
              thrive in today’s dynamic business world.</p>
            <div class="d-flex justify-content-start align-items-start describeData">
              <div class="">
                <p>Type<span> Doctorate </span> </p>
              </div>
              <div class="">
                <p>Start Date<span> Dec 24, 2024 </span> </p>
              </div>
              <div class="">
                <p class="">Duration <span>36 Months </span></p>
              </div>
            </div>
            <div class="d-lg-flex d-md-block d-block justify-content-start align-items-start">
              <button class="downloadBtn mb-lg-0 mb-md-0 mb-3"  data-bs-toggle="modal" data-bs-target="#signup">Download Brochure</button>
              <button class="applyBtn"  data-bs-toggle="modal" data-bs-target="#signup">Apply Now</button>
            </div>
            <div class="d-flex enquiryData">
              <i class="fa-solid fa-phone"></i>
              <div class="">For enquiries call: 1800 210 2020</div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="rightProgramme">
            <img alt="banner image" class="w-100 h-100" src="images/programme/doctorate/ESGCI.webp">
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="heading-Theme">
            <p class="text-capitalize">Doctorate of Business Administration, ESGCI Paris </p>
            <h3> Key Program <span>Highlights </span></h3>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="d-flex KeyFeatureCount">
            <p><span>180 ECTS </span> Credits</p>
            <p><span>5-Day </span> Immersion in Paris</p>
            <p><span> 1 :1</span> Thesis Supervision </p>
          </div>
          <ul class="keyHighlights">
            <li> <i class="fa-regular fa-circle-check"></i> Earn a European Doctorate from ESGCI Paris </li>
            <li> <i class="fa-regular fa-circle-check"></i> Strong Focus on Leadership </li>
            <li> <i class="fa-regular fa-circle-check"></i> Accelerate Your DBA Course: Complete in as little as 2 years
            </li>
            <li> <i class="fa-regular fa-circle-check"></i> Guided by Top Faculty from ESGCI School of Management </li>
            <li> <i class="fa-regular fa-circle-check"></i> Earn 3 Key Credentials: 2 interim certificates, 1 Doctorate
            </li>
            <li> <i class="fa-regular fa-circle-check"></i> Global Standards: ACBSP and IACBE Member </li>
            <li> <i class="fa-regular fa-circle-check"></i> Accredited Nationally: French Ministry recognition </li>
          </ul>
        </div>
        <div class="col-lg-4">
          <div class="">
            <img src="images/programme/doctorate/Paris.webp" class="img-fluid w-100">
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="needMore">
            <h3> Need to know more? </h3>
            <h6> Get to know the DBA course in-depth by downloading the program syllabus </h6>
            <a href="#" class="btn btn-primary mt-3"> Download Syllabus </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="heading-Theme">
            <p class="text-capitalize">Doctor of Business Administration Course,ESGCI </p>
            <h3> <span>Transform Your Leadership Career </span> with This DBA from ESGCI Paris</h3>
          </div>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-lg-4 col-md-4 col-6">
          <div class="TransformGrid">
            <div class="icon">
              <i class="fa-solid fa-award"></i>
            </div>
            <h4> Identify Your Unique Leadership Strengths </h4>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-6">
          <div class="TransformGrid">
            <div class="icon">
              <i class="fa-solid fa-award"></i>
            </div>
            <h4> Lead Business Transformation with Global Insights </h4>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-6">
          <div class="TransformGrid">
            <div class="icon">
              <i class="fa-solid fa-award"></i>
            </div>
            <h4> Experience a 5-Day Immersion in Paris </h4>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-6">
          <div class="TransformGrid">
            <div class="icon">
              <i class="fa-solid fa-award"></i>
            </div>
            <h4> Drive Change with Focused Leadership Research </h4>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-6">
          <div class="TransformGrid">
            <div class="icon">
              <i class="fa-solid fa-award"></i>
            </div>
            <h4> Earn Three Key Credentials </h4>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-6">
          <div class="TransformGrid">
            <div class="icon">
              <i class="fa-solid fa-award"></i>
            </div>
            <h4> Join a Global Network of Business Leaders </h4>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="empowerExpertise pb-3">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="heading-Theme text-center">
            <h3> From <span>Senior Leader to Respected Doctor </span> </h3>
            <h6>Empower Your Expertise. Earn the Coveted Dr.’s Title² That Elevates Your Authority and Influence.</h6>
          </div>
        </div>
      </div>


      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="expertiseStudent beforeStudent">
          <p> Before </p>
          <h4> Neha Patel</h4>
        </div>
        <div class="beforeStudent d-flex align-items-center">
          <div class="">
            <img src="images/programme/doctorate/arrow-with-circle.svg">
          </div>
          <div class="centerProfile">
            <img src="images/i-university-logo-01.png" class="profileLogo">
            <img src="images/programme/doctorate/ESGCINehaPatel.webp">
            <p class="otherBottom"></p>
          </div>
          <div class="">
            <img src="images/programme/doctorate/arrow-right.svg">
          </div>
        </div>
        <div class="expertiseStudent afterStudent">
          <p> After </p>
          <h4> Dr. Neha Patel</h4>
        </div>
      </div>
      <div class="text-center mt-5">
        <a href="#" class="btn btn-primary mt-3">Talk to a Program Expert </a>
      </div>

    </div>
  </section>
  <section class="whyUs">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="heading-Theme">
            <p class="text-capitalize">DBA Program-The Credential That Combines Expertise, Research, and Leadership </p>
            <h3>Why should you choose a <span>DBA over a PhD? </span> </h3>
          </div>
        </div>
      </div>
      <div class="row g-0 mt-4 align-items-end">
        <div class="col-lg-4">
          <div class="whyChooseTable">
            <h4> </h4>
            <ul class="firstColChoose">
              <li><i class="fa-regular fa-pen-to-square"></i> Program Focus </li>
              <li><i class="fa-solid fa-chart-line"></i> Career Enhancement </li>
              <li><i class="fa-regular fa-clock"></i> Time Commitment </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="whyChooseTable centerColumn">
            <h4> DBA </h4>
            <ul>
              <li><i class="fa-regular fa-thumbs-up"></i>
                <p> Scholar-practitioner approach toward solving real-world business challenges </p>
              </li>
              <li><i class="fa-regular fa-thumbs-up"></i>
                <p> Ideal for career progression in business management, executive leadership, or consulting </p>
              </li>
              <li><i class="fa-regular fa-thumbs-up"></i>
                <p> Finish in as little as 3 years¹ </p>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="whyChooseTable">
            <h4><span>PhD </span></h4>
            <ul>
              <li><i class="fa-regular fa-thumbs-up"></i>
                <p> Ideal for those pursuing an academic or high-level research career </p>
              </li>
              <li><i class="fa-regular fa-thumbs-up"></i>
                <p> Best suited for individuals seeking to contribute to academic theory and research </p>
              </li>
              <li><i class="fa-regular fa-thumbs-up"></i>
                <p> Longer and More intensive </p>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="d-lg-flex d-md-block d-block justify-content-start align-items-start mt-4 w-50 m-auto ">
        <button class="downloadBtn mb-lg-0 mb-md-0 mb-3"  data-bs-toggle="modal" data-bs-target="#signup">Download Brochure</button>
        <button class="applyBtn"  data-bs-toggle="modal" data-bs-target="#signup">Talk to Program Expert</button>
      </div>


    </div>
  </section>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="heading-Theme">
            <h3 class="mb-4"><span>ESGCI,</span> Established 1986 </h3>
            <p class="paradetail">ESGCI International School of Management, Paris, is a renowned institution specializing in management
              studies with a strong international focus. Recognized by the French Ministry of Higher Education, ESGCI
              has over 20% international students from 65 nationalities. It holds QUALIOPI certification for
              high-quality training and is a member of ACBSP. As part of Galileo Global Education, ESGCI benefits from a
              vast network across 91 campuses in 13 countries.</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="establishVideo">
            <img src="images/programme/doctorate/ESGIVideo.webp" class="img-fluid">
            <div class="overlay">
              <a href="#"><img src="images/programme/doctorate/play-button.svg"></a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="heading-Theme">
            <p class="text-capitalize"> Quality Assured </p>
            <h3>Internationally Recognised and Accredited </h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="Quality-theme theme-carusel owl-carousel">
            <div class="product-card p-0 overflow-hidden m-0">
              <div class="position-relative">
                <img src="images/programme/doctorate/Qualiopi.webp" class="img-fluid" />
              </div>
              <div class="caption-product">
                <h5 class="mb-2">QUALIOPI</h5>
                <p> Holds QUALIOPI certification: A quality mark for training organizations registered with the National
                  Institute of Industrial Property (INPI). </p>
              </div>
            </div>
            <div class="product-card p-0 overflow-hidden m-0">
              <div class="position-relative">
                <img src="images/programme/doctorate/AccreditationsMinistryHigher.jpg" class="img-fluid" />
              </div>
              <div class="caption-product">
                <h5 class="mb-2">French Ministry of Higher Education</h5>
                <p> ESGCI is recognized by the French Ministry of Higher Education Research and Innovation, it
                  Implements the government's policy on access to knowledge and the growth of higher education. </p>
              </div>
            </div>
            <div class="product-card p-0 overflow-hidden m-0">
              <div class="position-relative">
                <img src="images/programme/doctorate/Accreditations.webp" class="img-fluid" />
              </div>
              <div class="caption-product">
                <h5 class="mb-2">ACBSP</h5>
                <p> ESGCI is recognized by the French Ministry of Higher Education Research and Innovation, it
                  Implements the government's policy on access to knowledge and the growth of higher education. </p>
              </div>
            </div>
            <div class="product-card p-0 overflow-hidden m-0">
              <div class="position-relative">
                <img src="images/programme/doctorate/Accreditationsiacb.webp" class="img-fluid" />
              </div>
              <div class="caption-product">
                <h5 class="mb-2">IACBE</h5>
                <p> ESGCI is recognized by the French Ministry of Higher Education Research and Innovation, it
                  Implements the government's policy on access to knowledge and the growth of higher education. </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="heading-Theme w-75">
            <p class="text-capitalize"> Doctorate Degree in Business Administration </p>
            <h3>Earn the Prestigious DBA Degree from ESGCI, Paris </h3>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="listingEarn">
            <ul>
              <li>
                <div class="icon"> <i class="fa-solid fa-award"></i> </div>
                <div class="captionList">
                  <h4> Same Doctorate as On-Campus </h4>
                  <p> Receive the same world-class education and global recognition without needing to relocate.</p>
                </div>
              </li>
              <li>
                <div class="icon"> <i class="fa-solid fa-certificate"></i> </div>
                <div class="captionList">
                  <h4> Nationally Accredited European Degree </h4>
                  <p> ESGCI holds QUALIOPI certification and awards RNCP qualifications, levels 6 (Bac+3) and 7 (Bac+5),
                    recognized by the State</p>
                </div>
              </li>
              <li>
                <div class="icon"> <i class="fa-solid fa-user"></i> </div>
                <div class="captionList">
                  <h4> Lifetime Alumni Status </h4>
                  <p> Join a global network of professionals, many in key leadership roles worldwide.</p>
                </div>
              </li>
            </ul>
          </div>

        </div>
        <div class="col-lg-5">
          <img src="images/programme/doctorate/490x360.webp" class="img-fluid">
        </div>
      </div>
    </div>
  </section>


  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="heading-Theme w-75">
            <p class="text-capitalize"> Connect. Collaborate. Grow. </p>
            <h3>Leaders from these Top Companies Have Enrolled </h3>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="listingEarn">
            <ul>
              <li>
                <div class="icon"> <i class="fa-solid fa-award"></i> </div>
                <div class="captionList">
                  <h4> Seasoned Professionals </h4>
                  <p> Collaborate with seasoned industry leaders with over 12 years of business experience.</p>
                </div>
              </li>
              <li>
                <div class="icon"> <i class="fa-solid fa-star"></i> </div>
                <div class="captionList">
                  <h4> Executive-Level Participants</h4>
                  <p> Over 65% of our students are C-suite/senior executives, offering unparalleled networking and
                    mentorship opportunities.</p>
                </div>
              </li>
              <li>
                <div class="icon"> <i class="fa-solid fa-user"></i> </div>
                <div class="captionList">
                  <h4> Cross-Industry Collaboration</h4>
                  <p> Expand your network with leaders from 10+ industries. </p>
                </div>
              </li>
            </ul>
          </div>

        </div>
        <div class="col-lg-5">
          <img src="images/programme/doctorate/ESG20.webp" class="img-fluid">
        </div>
      </div>
    </div>
  </section>

  <section class="whyUs">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="heading-Theme">
            <p class="text-capitalize">Leaders driving change </p>
            <h3>A Snapshot of <span>Our Learners in Leading Companies </span> </h3>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="programuser">
            <ul>
              <li><i class="fa-regular fa-user"></i>
                <div class="instructor">
                  <h5> 5 </h5>
                  <p> Learner Profiles </p>
                </div>
              </li>
            </ul>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="courses-tab mt-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="learner-tab" data-bs-toggle="tab" data-bs-target="#learner"
                  type="button" role="tab" aria-controls="learner" aria-selected="true">Learner Profiles
                </button>
              </li>
            </ul>
          </div>
          <div class="course-content">
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="learner" role="tabpanel" aria-labelledby="PopularCourse-tab">
                <div class="LearnerSlider theme-carusel owl-carousel">
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>
                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



    </div>
  </section>

  <section class="whyUs">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="heading-Theme">
            <p class="text-capitalize">ESGCI International School of Management,Paris </p>
            <h3>Who will you <span>learn from? </span> </h3>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="programuser">
            <ul>
              <li><i class="fa-regular fa-user"></i>
                <div class="instructor">
                  <h5> 3 </h5>
                  <p> Instructors </p>
                </div>
              </li>
              <li><i class="fa-regular fa-user"></i>
                <div class="instructor">
                  <h5> 4 </h5>
                  <p> Thesis Supervisors </p>
                </div>
              </li>
              <li><i class="fa-regular fa-user"></i>
                <div class="instructor">
                  <h5> 3 </h5>
                  <p> Leadership Experts </p>
                </div>
              </li>
            </ul>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="courses-tab mt-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="instructor-tab" data-bs-toggle="tab" data-bs-target="#instructor"
                  type="button" role="tab" aria-controls="instructor" aria-selected="true">Instructors
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="thesis-tab" data-bs-toggle="tab" data-bs-target="#thesis" type="button"
                  role="tab" aria-controls="thesis" aria-selected="true">Thesis Supervisors
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="leadershipexpert-tab" data-bs-toggle="tab"
                  data-bs-target="#leadershipexpert" type="button" role="tab" aria-controls="leadershipexpert"
                  aria-selected="true">Leadership Experts
                </button>
              </li>
            </ul>
          </div>
          <div class="course-content">
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="instructor" role="tabpanel" aria-labelledby="instructor-tab">
                <div class="LearnerSlider theme-carusel owl-carousel">
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>


                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                  <div class="product-card product-item">
                    <div class="learnerSpace">
                      <img src="images/programme/doctorate/SumeetBhat.webp" />
                      <div class="nameDetail">
                        <h6>Sumeet Bhat </h6>
                        <img src="images/programme/doctorate/whirlpool.png" class="BrandLogo">
                      </div>
                    </div>
                    <div class="d-flex flex-column mt-3">
                      <div class="d-flex flex-column my-3">
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-user"></i>
                          <p class="font-450 text-dark">Director of Engineering - Whirlpool</p>
                        </div>
                        <div class="d-flex align-items-start info-data">
                          <i class="fa-regular fa-clock"></i>
                          <p class="font-450 text-dark">Former President, Scientific Affairs - Trivitron | Former
                            Director - Philips | Certified Six Sigma Black Belt</p>
                        </div>
                      </div>
                      <a href="#" target="_blank" class="d-flex align-items-end text-linkedin mt-2">
                        <span class="text-underline">LinkedIn Profile</span>
                        <img alt="Linkedin" src="images/instructor/Linkedin.svg"></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="thesis" role="tabpanel" aria-labelledby="thesis-tab">
                ff
              </div>
              <div class="tab-pane fade" id="leadershipexpert" role="tabpanel" aria-labelledby="leadershipexpert-tab">
                ffg
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
  </section>
  <section class="whyUs">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="heading-Theme">
            <p class="text-capitalize">DBA Course Syllabus, ESGCI Paris </p>
            <h3>Detailed Curriculum </h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <ul class="nav nav-tabs curriculumtab theme-carusel owl-carousel" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                role="tab" aria-controls="home" aria-selected="true">
                <span> Course 1</span>
                Introduction to Doctoral Research</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                role="tab" aria-controls="profile" aria-selected="false">
                <span> Course 2</span>
                Formulating a Research Topic</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">
                <span> Course 3</span>
                Data Collection (Optional) </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">
                <span> Course 4</span>
                Data Collection (Optional) </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">
                <span> Course 5</span>
                Data Collection (Optional) </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">
                <span> Course 6</span>
                Data Collection (Optional) </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">
                <span> Course 7</span>
                Data Collection (Optional) </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">
                <span> Course 8</span>
                Data Collection (Optional) </button>
            </li>
          </ul>
          <div class="tab-content curriculumContent" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <h6> Introduction to Doctoral Research </h6>
              <p>Develop research skills to conduct and present doctoral-level research effectively. </p>
              <p> Topics Covered </p>
              <ul class="keyHighlights">
                <li><i class="fa-regular fa-circle-check"></i> Foundational Concepts in Academic Research </li>
                <li><i class="fa-regular fa-circle-check"></i> The Nature and Types of Academic Research </li>
                <li><i class="fa-regular fa-circle-check"></i> Key Terminologies in Doctoral Research </li>
                <li><i class="fa-regular fa-circle-check"></i> Features of Business and Management Research </li>
                <li><i class="fa-regular fa-circle-check"></i> Steps in the Doctoral Research Process </li>
              </ul>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <h6> Formulating a Research Topic and Reviewing Literature </h6>
              <p> Articulate a well-defined research topic, identify relevant sources, evaluate their credibility, and
                conduct a comprehensive literature review.</p>
              <p> Topics Covered </p>
              <ul class="keyHighlights">
                <li><i class="fa-regular fa-circle-check"></i> Formulating a Research Question </li>
                <li><i class="fa-regular fa-circle-check"></i> Writing a Research Proposal </li>
                <li><i class="fa-regular fa-circle-check"></i> Developing a Strong Research Design </li>
                <li><i class="fa-regular fa-circle-check"></i> Literature Review: relevance, types, approaches, and
                  methods </li>
                <li><i class="fa-regular fa-circle-check"></i> Drafting the Literature Review </li>
              </ul>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
              <h6> Introduction to Doctoral Research </h6>
              <p>Develop research skills to conduct and present doctoral-level research effectively. </p>
              <p> Topics Covered </p>
              <ul class="keyHighlights">
                <li><i class="fa-regular fa-circle-check"></i> Fundamentals of Quantitative Data Collection </li>
                <li><i class="fa-regular fa-circle-check"></i> Secondary Data Sources </li>
                <li><i class="fa-regular fa-circle-check"></i> Collecting and Evaluating Primary Data </li>
                <li><i class="fa-regular fa-circle-check"></i> Qualitative Data Collection Methods </li>
                <li><i class="fa-regular fa-circle-check"></i> Data Validity and Reliability, Quality of Data </li>
              </ul>
            </div>
          </div>
          <div class="text-center mt-5">
            <a href="#" class="btn btn-primary">Download Syllabus <i class="fa-solid fa-download"></i> </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="whyUs">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="heading-Theme text-center">
            <p class="text-capitalize">DBA Degree Learning Journey </p>
            <h3>Your Transformative<br> Journey to the Doctorate <br> Degree</h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="timeline">
            <ul>
              <li>
                <div class="content">
                  <h3>Start Your DBA Journey</h3>
                  <ul>
                    <li> <i class="fa-regular fa-circle-check"></i> Begin your transformative leadership path.</li>
                  </ul>
                </div>

              </li>
              <li>
                <div class="content">
                  <h3>Foundation-Focused Coursework</h3>
                  <ul>
                    <li> <i class="fa-regular fa-circle-check"></i> Introduction to Doctoral Research </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Formulating Research Topic and Literature Review
                    </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Quantitative and Qualitative Methods </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Access and Collect Data </li>
                  </ul>
                </div>
              </li>
              <li>
                <div class="content">
                  <h3>Specialization and CliftonStrengths Assessment</h3>
                  <ul>
                    <li> <i class="fa-regular fa-circle-check"></i> Business Strategy and Innovation in the Digital Age
                    </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Leadership Skills: Leading People and Change </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Attempt CliftonStrengths, Leverage Strengths for
                      Leadership </li>
                  </ul>
                </div>
              </li>
              <li>
                <div class="content">
                  <h3>Work on Your Dissertation</h3>
                  <ul>
                    <li> <i class="fa-regular fa-circle-check"></i> Select a Real-World Business Problem </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Conduct a Literature Review, Identify Gaps </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Develop Research Design and Analyze Data </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Write, Revise, and Refine Dissertation </li>
                  </ul>
                </div>
              </li>
              <li>
                <div class="content">
                  <h3>Defend the Dissertation and Collect the Degree</h3>
                  <ul>
                    <li> <i class="fa-regular fa-circle-check"></i> Present and Defend Your Dissertation </li>
                    <li> <i class="fa-regular fa-circle-check"></i> Attain Your DBA and Impact Globally </li>
                  </ul>
                </div>

              </li>

              <div style="clear:both;"></div>
            </ul>
          </div>
          <div class="text-center mt-3">
            <a href="#" class="btn btn-primary">Talk to a Program Expert </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="heading-Theme ">
            <p class="text-capitalize">Enhance Your DBA Program </p>
            <h3 class="mb-4">Paris Leadership Immersion </h3>
            <p class="paradetail">Immerse yourself in the business hub of Europe by networking with top faculty, industry leaders, and
              peers. Engage in intensive workshops, seminars, and collaborative projects to enhance your DBA journey.
              Experience the rich culture of Paris, exploring its iconic landmarks and diverse neighborhoods. Visit key
              industrial sites to gain real-world insights. Enrich your learning with the optional on-campus immersion,
              offering a truly transformative experience.</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="establishVideo">
            <img src="images/programme/doctorate/ESGCI2020.webp" class="img-fluid">
            <div class="overlay">
              <a href="#"><img src="images/programme/doctorate/play-button.svg"></a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="heading-Theme">
            <p class="text-capitalize">ESGCI, Paris DBA Course Fees </p>
            <h3>Invest In <span>Your Success </span> </h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="courses-tab mt-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="withoutimmersion-tab" data-bs-toggle="tab"
                  data-bs-target="#withoutimmersion" type="button" role="tab" aria-controls="withoutimmersion"
                  aria-selected="true">Course Fee (Without Immersion)
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="withimmersion-tab" data-bs-toggle="tab" data-bs-target="#withimmersion"
                  type="button" role="tab" aria-controls="withimmersion" aria-selected="true">Course Fee (With
                  Immersion)
                </button>
              </li>
            </ul>
          </div>
          <div class="course-content">
            <div class="tab-content mt-4" id="myTabContent">
              <div class="tab-pane fade show active" id="withoutimmersion" role="tabpanel"
                aria-labelledby="withoutimmersion-tab">
                <div class="row align-items-center">
                  <div class="col-lg-4 offset-lg-1">
                    <div class="card courseFeeimmension">
                      <div class="card-body">
                        <span class="badge bg-light text-dark border rounded-pill d-inline-block px-3">36 Months</span>
                        <div class="heading-Course my-3">
                          <h3>Starting at <span class="d-block">INR 18,671/month </span> </h3>
                          <p>Totally <b>INR 8,14,000* </b><span class="text-muted"> No taxes applicable </span></p>
                        </div>
                        <p class="text-muted mb-1"><b> Inclusions </b></p>
                        <ul class="keyHighlights">
                          <li><i class="fa-regular fa-circle-check"></i> Pay as you learn with annual installment plan
                          </li>
                          <li><i class="fa-regular fa-circle-check"></i> 12 months no cost EMI available for each
                            installment </li>
                          <li><i class="fa-regular fa-circle-check"></i> Pay upfront and get additional waiver </li>
                        </ul>
                        <div class="d-flex flex-column justify-content-center text-center mt-4">
                          <a href="#" class="btn btn-primary"> Apply Now </a>
                          <a href="#" class="fs-6 mt-2 text-decoration-underline">Get Loan Details (3) </a>
                        </div>
                      </div>




                    </div>
                  </div>
                  <div class="col-lg-5 offset-lg-1">
                    <img src="images/programme/doctorate/person_laptop.svg" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="withimmersion" role="tabpanel" aria-labelledby="withimmersion-tab">
                <div class="row align-items-center">
                  <div class="col-lg-4 offset-lg-1">
                    <div class="card courseFeeimmension">
                      <div class="card-body">
                        <span class="badge bg-light text-dark border rounded-pill d-inline-block px-3">36 Months</span>
                        <div class="heading-Course my-3">
                          <h3>Starting at <span class="d-block">INR 24,327/month </span> </h3>
                          <p>Totally <b>INR 8,14,000* </b><span class="text-muted"> No taxes applicable </span></p>
                        </div>
                        <p class="text-muted mb-1"><b> Inclusions </b></p>
                        <ul class="keyHighlights">
                          <li><i class="fa-regular fa-circle-check"></i> Pay as you learn with annual installment plan
                          </li>
                          <li><i class="fa-regular fa-circle-check"></i> 12 months no cost EMI available for each
                            installment </li>
                          <li><i class="fa-regular fa-circle-check"></i> Pay upfront and get additional waiver </li>
                        </ul>
                        <div class="d-flex flex-column justify-content-center text-center mt-4">
                          <a href="#" class="btn btn-primary"> Apply Now </a>
                          <a href="#" class="fs-6 mt-2 text-decoration-underline">Get Loan Details (3) </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5 offset-lg-1">
                    <img src="images/programme/doctorate/person_laptop.svg" class="img-fluid">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>





    </div>
  </section>

  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="heading-Theme">
            <h3><span>FAQs </span>on Doctor of Business Administration </h3>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-3">
          <div class="nav flex-column nav-pills me-3 faqtab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">DBA Course Eligibility</button>
            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Payment</button>
            <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Refund Policy/Financials</button>
            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">No Cost Credit Card EMI FAQ's</button>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="tab-content faqContent" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
              <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Who is the DBA program from ESGCI for?
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                     <ul>
                      <li> Experienced professionals seeking an accelerated doctoral research journey. </li>
                      <li> Mid-level managers aiming for senior leadership roles and personal development. </li>
                      <li> Enthusiastic learners pursuing leadership-focused doctoral subjects with robust academic support </li>
                     </ul>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      What is the minimum eligibility for this program?
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <p>Master's Degree (or equivalent) or Bachelors Degree with 3+ years of work experience</p>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      What is the admission process?
                    </button>
                  </h2>
                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                     <p>Following are the key steps in the application process for the <b>Doctorate Degree in Business Administration: </b></p>
                      <p>
                        <span> 1. Submit application </span>
Complete your application by providing work experience and educational background. The admissions committee will review your application, including all required documentation.
<span>2. Shortlisting update </span>
Our admissions committee will review and accept your application. Upon acceptance, an offer letter will be sent to you confirming your admission to the Doctorate of Business Administration Program.
<span>3. Block your seat </span>
Reserve your program spot by paying the required program deposit (INR 35,000) in full by the date specified in your offer letter to begin your doctoral journey.
                      </p>
                   
                   
                   
                    </div>
                  </div>
                </div>
              </div>




            </div>
            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div>
            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
          </div>
        </div>
      </div>







    </div>
  </section>




  <section class="">
    <div class="container overflow-hidden">
      <div class="row">
        <div class="col-lg-12">
          <div class="heading-Theme">
            <h3> iUniversity<span> Learner Support </span> </h3>
            <p class="learnerSupport">Talk to our experts. We’re available 24/7.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="supportCountry">
            <ul>
              <li>
                <div class="d-flex">
                  <img src="images/support/india.webp">
                  <p> Indian Nationals </p>
                </div>
                <button> <i class="fa-solid fa-phone"></i> 1800 210 2020</button>
              </li>
              <li>
                <div class="d-flex">
                  <img src="images/support/other.webp">
                  <p> Foreign Nationals </p>
                </div>
                <button> <i class="fa-solid fa-phone"></i> +918045604032</button>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="disclaimer">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="heading-Theme">
            <h3 class="mb-4"> Disclaimer</h3>
            <p>iUniversity facilitates program delivery and is not a college/university in itself. Credits and credentials
              are awarded by the university. Please refer relevant terms and conditions before applying.</p>
            <p>Past record is no guarantee of future job prospects.</p>
            <p class="moretext">
              The success of job placement depends on various factors including but not limited to the individual's
              qualifications, experience, and efforts in seeking employment. Our organization makes no guarantees or
              representations regarding the level or timing of job placement.
            </p>
            <a class="moreless-button" href="javascript:void">Read More</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="container">
      <div class="d-flex justify-content-between footerLogo">

        <div class="leftLog">
          <img src="images/i-university-logo-white-01.png">
          <p>Building Careers of Tomorrow</p>
          <div class="socialIcon">
            <ul>
              <li><a href="#"><img src="images/footer/social/fb.svg"> </a></li>
              <li><a href="#"><img src="images/footer/social/twitter.svg"> </a></li>
              <li><a href="#"><img src="images/footer/social/linkedin.svg"> </a></li>
              <li><a href="#"><img src="images/footer/social/YouTube.svg"> </a></li>
            </ul>
          </div>
        </div>
        <div class="rightLog">
          <a href="#"> <i class="fa-brands fa-android"></i> get the android app </a>
          <a href="#"> <i class="fa-brands fa-apple"></i> get the android app </a>
        </div>

      </div>
      <div class="footerMenu">
        <div class="row">
          <div class="col-lg-3">
            <h4 class="footer-title">
              iUniversity
            </h4>
            <ul>
              <li><a href="#">About </a></li>
              <li><a href="#">Careers </a></li>
              <li><a href="#">Placement Support </a></li>
              <li><a href="#">iUniversity Blog </a></li>
              <li><a href="#">iUniversity Tutorials </a></li>
              <li><a href="#">Resources </a></li>
              <li><a href="#">iUniversity Free Courses </a></li>
              <li><a href="#">For Teams </a></li>
              <li><a href="#">Data Science Programs for Teams </a></li>
              <li><a href="#">Product and Technology Programs for Teams </a></li>
              <li><a href="#">Management Programs for Teams </a></li>
              <li><a href="#">Online Power Learning </a></li>
              <li><a href="#">Xchange </a></li>
              <li><a href="#">BaseCamp </a></li>
              <li><a href="#">For Business </a></li>
              <li><a href="#">Watch Free Videos </a></li>
              <li><a href="#">iUniversity In Media </a></li>
              <li><a href="#">Reviews </a></li>
            </ul>
          </div>
          <div class="col-lg-3">
            <h4 class="footer-title">
              Support
            </h4>
            <ul>
              <li><a href="#">Contact </a></li>
              <li><a href="#">Experience Centers </a></li>
              <li><a href="#">Grievance Redressal </a></li>
              <li><a href="#">Terms & Conditions </a></li>
              <li><a href="#">Privacy Policy </a></li>
              <li><a href="#">Report a Vulnerability </a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footerMenu">
        <div class="row">
          <div class="col-lg-3">
            <h4 class="footer-title">
              MBA
            </h4>
            <ul>
              <li><a href="#">Liverpool Business School </a></li>
              <li><a href="#">Deakin Business School </a></li>
              <li><a href="#">Golden Gate University </a></li>
              <li><a href="#">PG Diploma in Management </a></li>
              <li><a href="#">Management </a></li>
              <li><a href="#">O.P.Jindal Global University </a></li>
              <li><a href="#">(MBA) from iUniversity Tech Pte Ltd </a></li>
              <li><a href="#">Global Business Management </a></li>
              <li><a href="#">General Management </a></li>
              <li><a href="#">BIMTECH </a></li>
              <li><a href="#">Management </a></li>
              <li><a href="#">Harappa School of Leadership </a></li>
              <li><a href="#">Deakin Business School </a></li>
              <li><a href="#">International Finance (integrated with ACCA, UK) </a></li>
              <li><a href="#">Generative AI </a></li>
              <li><a href="#">Business & Law </a></li>
            </ul>
          </div>
          <div class="col-lg-3">
            <h4 class="footer-title">
              Data Science & Analytics
            </h4>
            <ul>
              <li><a href="#">Data Science </a></li>
              <li><a href="#">Data Science </a></li>
              <li><a href="#">Business Analytics </a></li>
              <li><a href="#">Data Science and Machine Learning </a></li>
              <li><a href="#">Business Analytics </a></li>
              <li><a href="#">Data Science & AI </a></li>
              <li><a href="#">Data Science and Business Analytics </a></li>
              <li><a href="#">Business Analytics MSU </a></li>
              <li><a href="#">Business Analytics </a></li>
              <li><a href="#">Data Science & Analytics Bootcamp </a></li>
            </ul>
          </div>
          <div class="col-lg-3">
            <h4 class="footer-title">
              Doctorate
            </h4>
            <ul>
              <li><a href="#">Golden Gate University </a></li>
              <li><a href="#">Business Administration ESGCI </a></li>
              <li><a href="#">Rushford Business School </a></li>
              <li><a href="#">Swiss School of Business and Management </a></li>
              <li><a href="#">Golden Gate University </a></li>
              <li><a href="#">Golden Gate University </a></li>
            </ul>
          </div>
          <div class="col-lg-3">
            <h4 class="footer-title">
              Software & Tech
            </h4>
            <ul>
              <li><a href="#">Cloud Computing and DevOps Program by IIITB - (Executive) </a></li>
              <li><a href="#">DevOps Engineer Bootcamp </a></li>
              <li><a href="#">Full Stack Software Development Bootcamp </a></li>
              <li><a href="#">Cloud Computing </a></li>
              <li><a href="#">UI/UX Design Bootcamp </a></li>
              <li><a href="#">iUniversity </a></li>
              <li><a href="#">ITIL® 4 Foundation Certification Training </a></li>
              <li><a href="#">Python Programming Certification Training </a></li>
              <li><a href="#">Angular Training </a></li>
              <li><a href="#">React JS Training </a></li>
              <li><a href="#">Certified Ethical Hacking Course (CEH v12) </a></li>
              <li><a href="#">AWS Certified Solutions Architect - Associate Training </a></li>
              <li><a href="#">AWS Cloud Practitioner Essentials Certification Training </a></li>
              <li><a href="#">Azure Solution Architect Certification (AZ-305T00-A) </a></li>
              <li><a href="#">Azure Administrator Certification (AZ-104) </a></li>
              <li><a href="#">Azure Data Engineering Certification Training (DP-203T00) </a></li>
              <li><a href="#">Advanced Full Stack Development </a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footerMenu">
        <div class="row">
          <div class="col-lg-3">
            <h4 class="footer-title">
              AI & ML
            </h4>
            <ul>
              <li><a href="#">Machine Learning & AI </a></li>
              <li><a href="#">Machine Learning & AI </a></li>
              <li><a href="#">Data Science and Machine Learning </a></li>
              <li><a href="#">GenerativeAI </a></li>
              <li><a href="#">Full Stack AI and ML - 100% on-campus </a></li>
              <li><a href="#">Machine Learning & NLP </a></li>
              <li><a href="#">Machine Learning & Deep Learning </a></li>
              <li><a href="#">AI & Machine Learning Bootcamp: Master the Future </a></li>
            </ul>
          </div>
          <div class="col-lg-3">
            <h4 class="footer-title">
              Marketing
            </h4>
            <ul>
              <li><a href="#">Digital Marketing and Communication </a></li>
              <li><a href="#">Brand Communication Management </a></li>
              <li><a href="#">Digital Marketing </a></li>
              <li><a href="#">Generative AI </a></li>
            </ul>
          </div>
          <div class="col-lg-3">
            <h4 class="footer-title">
              Management
            </h4>
            <ul>
              <li><a href="#">HR Management and Analytics </a></li>
              <li><a href="#">Product Management </a></li>
              <li><a href="#">Human Resource Management </a></li>
              <li><a href="#">Integrated Supply Chain Management </a></li>
              <li><a href="#">Healthcare Management </a></li>
              <li><a href="#">Management </a></li>
              <li><a href="#">Management </a></li>
              <li><a href="#">Management Essentials </a></li>
              <li><a href="#">International Finance (integrated with ACCA, UK) </a></li>
              <li><a href="#">Product Management </a></li>
              <li><a href="#">Strategic Human Resources Leadership Cornell </a></li>
              <li><a href="#">Human Resources Management for Indian Executives </a></li>
              <li><a href="#">Effective Leadership and Management </a></li>
              <li><a href="#">CSM® Certification Training </a></li>
              <li><a href="#">CSPO® Certification Training </a></li>
              <li><a href="#">Leading SAFe® 6.0 Training </a></li>
              <li><a href="#">SAFe® 6.0 POPM Certification </a></li>
              <li><a href="#">SAFe® 6.0 Scrum Master Certification </a></li>
              <li><a href="#">Implementing SAFe® 6.0 with SPC Certification </a></li>
              <li><a href="#">SAFe® 6.0 Release Train Engineer (RTE) Certification </a></li>
              <li><a href="#">PMP® Certification Training </a></li>
              <li><a href="#">PRINCE2® Foundation and Practitioner Certificatio </a></li>
            </ul>
          </div>
          <div class="col-lg-3">
            <h4 class="footer-title">
              Law
            </h4>
            <ul>
              <li><a href="#">Corporate & Financial Law </a></li>
              <li><a href="#">Intellectual Property & Technology Law </a></li>
              <li><a href="#">Dispute Resolution </a></li>
              <li><a href="#">Contract Law Certificate Program </a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footerMenu">
        <div class="row">
          <div class="col-lg-3">
            <h4 class="footer-title">
              Job Linked
            </h4>
            <ul>
              <li><a href="#"> Management </a></li>
              <li><a href="#"> DevOps Engineer Bootcamp </a></li>
              <li><a href="#"> Bootcamp </a></li>
              <li><a href="#"> Data Science Bootcamp </a></li>
              <li><a href="#"> Advanced Full Stack Development </a></li>
              <li><a href="#"> Data Science & Analytics Bootcamp </a></li>
              <li><a href="#"> Cloud Computing </a></li>
              <li><a href="#"> UI/UX Design </a></li>
              <li><a href="#"> AI & Machine Learning Bootcamp: Master the Future </a></li>
            </ul>
          </div>
          <div class="col-lg-3">
            <h4 class="footer-title">
              Bootcamps
            </h4>
            <ul>
              <li><a href="#">Data Science & Analytics Bootcamp </a></li>
              <li><a href="#">Full Stack Software Development Bootcamp </a></li>
              <li><a href="#">UI/UX Design Bootcamp </a></li>
              <li><a href="#">Cloud Computing </a></li>
              <li><a href="#">Sales Excellence Bootcamp </a></li>
              <li><a href="#">Advanced Full Stack Development </a></li>
              <li><a href="#">DevOps Engineer Bootcamp </a></li>
              <li><a href="#">Generative AI & Machine Learning Bootcamp: Master the Future of Technology </a></li>
              <li><a href="#">Data Engineer Bootcamp </a></li>
              <li><a href="#">Data Analytics </a></li>
              <li><a href="#">AI Engineer Bootcamp </a></li>
              <li><a href="#">Front-End Development Bootcamp </a></li>
              <li><a href="#">Back-End Development Bootcamp </a></li>
            </ul>
          </div>
          <div class="col-lg-3">
            <h4 class="footer-title">
              Study Abroad
            </h4>
            <ul>
              <li><a href="#">Master of Business Administration (90 ECTS) </a></li>
              <li><a href="#">Master of Business Administration (60 ECTS) </a></li>
              <li><a href="#">Computer Science </a></li>
              <li><a href="#">MS in Data Analytics </a></li>
              <li><a href="#">Project Management </a></li>
              <li><a href="#">Information Technology </a></li>
              <li><a href="#">International Management </a></li>
              <li><a href="#">Bachelor of Business Administration (180 ECTS) </a></li>
              <li><a href="#">B.Sc. Computer Science (180 ECTS) </a></li>
              <li><a href="#">Masters Degree in Data Analytics and Visualization </a></li>
              <li><a href="#">Masters Degree in Artificial Intelligence </a></li>
              <li><a href="#">MBS in Entrepreneurship and Marketing </a></li>
              <li><a href="#">MSc in Data Analytics </a></li>
              <li><a href="#">MBA - Information Technology Concentration </a></li>
              <li><a href="#">MS in Data Analytics </a></li>
              <li><a href="#">Master of Science in Accountancy </a></li>
              <li><a href="#">MS in Computer Science </a></li>
              <li><a href="#">Master of Science in Business Analytics </a></li>
              <li><a href="#">MS in Data Science </a></li>
              <li><a href="#">MS in Information Technology </a></li>
              <li><a href="#">Master of Business Administration </a></li>
              <li><a href="#">MS in Applied Data Science </a></li>
              <li><a href="#">Master of Business Administration </a></li>
              <li><a href="#">MS in Data Analytics </a></li>
              <li><a href="#">M.Sc. Data Science (60 ECTS) </a></li>
              <li><a href="#">Master of Business Administration </a></li>
              <li><a href="#">MS in Information Technology and Administrative Management </a></li>
              <li><a href="#">MS in Computer Science </a></li>
              <li><a href="#">Master of Business Administration </a></li>
              <li><a href="#">MBA General Management-90 ECTS </a></li>
              <li><a href="#">MSc International Business Management </a></li>
              <li><a href="#">MBA Business Technologies </a></li>
              <li><a href="#">MBA Leading Business Transformation </a></li>
              <li><a href="#">Master of Business Administration </a></li>
              <li><a href="#">MSc Business Intelligence and Data Science </a></li>
              <li><a href="#">MS Data Analytics </a></li>
              <li><a href="#">MS in Management Information Systems </a></li>
              <li><a href="#">MSc International Business and Management </a></li>
              <li><a href="#">MS Engineering Management </a></li>
              <li><a href="#">MS in Machine Learning Engineering </a></li>
              <li><a href="#">MS in Engineering Management </a></li>
              <li><a href="#">MSc Data Engineering </a></li>
              <li><a href="#">MSc Artificial Intelligence Engineering </a></li>
              <li><a href="#">MPS in Informatics </a></li>
              <li><a href="#">MPS in Applied Machine Intelligence </a></li>
              <li><a href="#">MS in Project Management </a></li>
              <li><a href="#">MPS in Analytics </a></li>
              <li><a href="#">MBA International Business Management </a></li>
              <li><a href="#">MS in Project Management </a></li>
              <li><a href="#">MS in Organizational Leadership </a></li>
              <li><a href="#">MPS in Analytics - NEU Canada </a></li>
              <li><a href="#">MBA with specialization </a></li>
              <li><a href="#">MPS in Informatics - NEU Canada </a></li>
              <li><a href="#">Master in Business Administration </a></li>
              <li><a href="#">MS in Digital Marketing and Media </a></li>
              <li><a href="#">MS in Project Management </a></li>
              <li><a href="#">Master in Logistics and Supply Chain Management </a></li>
              <li><a href="#">MSc Sustainable Tourism and Event Management </a></li>
              <li><a href="#">MSc in Circular Economy and Sustainable Innovation </a></li>
              <li><a href="#">MSc in Impact Finance and Fintech Management </a></li>
              <li><a href="#">MS Computer Science </a></li>
              <li><a href="#">MS in Applied Statistics </a></li>
              <li><a href="#">MS in Computer Information Systems </a></li>
            </ul>
          </div>
          <div class="col-lg-3">
            <h4 class="footer-title">
              For College Students
            </h4>
            <ul>
              <li><a href="#">Digital Marketing </a></li>
              <li><a href="#">Business Analytics & Consulting with PwC India </a></li>
              <li><a href="#">Financial Modelling & Analysis with PwC India </a></li>
              <li><a href="#">Data Science & Artificial Intelligence </a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footerMenu">
        <div class="row">
          <div class="col-lg-3">
            <h4 class="footer-title">
              Supply Chain Management
            </h4>
            <ul>
              <li><a href="#"> Integrated Supply Chain Management </a></li>

            </ul>
          </div>
          <div class="col-lg-3">
            <h4 class="footer-title">
              Archived Programs
            </h4>
            <ul>
              <li><a href="#"> iUniversity's Job-Linked Advanced General Program </a></li>
              <li><a href="#"> Full Stack AI and ML - 100% on-campus </a></li>
              <li><a href="#"> Generative AI for Tech Professionals </a></li>
              <li><a href="#"> Generative AI for Law Professionals </a></li>
              <li><a href="#"> Doctor of Juridical Science (SJD) </a></li>
              <li><a href="#"> Computer Science </a></li>
              <li><a href="#"> Software Development - Spl. in Full Stack Development </a></li>
              <li><a href="#"> Professional Certificate Program In General Management </a></li>
              <li><a href="#"> Professional Certificate Program In Marketing And Sales Management </a></li>
              <li><a href="#"> International Business and Finance Law </a></li>
              <li><a href="#"> CMO Program - ACP in Marketing Leadership Development </a></li>
              <li><a href="#"> Leadership and Management in New Age Businesses </a></li>
            </ul>
          </div>

        </div>
      </div>
      <div class="copyright">
        <p>© 2015-2024 iUniversity Education Private Limited. All rights reserved</p>
      </div>
    </div>
  </footer>



  <script src="js/jquery-1.11.0.min.js"></script>
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/intlTelInput-jquery.min.js"></script>
  <script>
    $("#mobile_code").intlTelInput({
      initialCountry: "in",
      separateDialCode: true,
    });
  </script>
  <script>
    $('.moreless-button').click(function () {
      $('.moretext').slideToggle();
      if ($('.moreless-button').text() == "Read more") {
        $(this).text("Read less")
      } else {
        $(this).text("Read more")
      }
    });
  </script>


  <script>
    $('.product-slider').owlCarousel({
      loop: true,
      margin: 30,
      autoplay: true,
      nav: false,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 3
        }
      }
    })
  </script>
  <script>
    $('.brandEmployee').owlCarousel({
      loop: true,
      margin: 30,
      autoplay: true,
      nav: false,
      autoplayTimeout: 1000,
      autoplaySpeed: 1000,
      fluidSpeed: true,
      responsive: {
        0: {
          items: 2
        },
        600: {
          items: 4
        },
        1000: {
          items: 8
        }
      }
    });
    $('.brandPartner').owlCarousel({
      loop: true,
      margin: 30,
      autoplay: true,
      nav: false,
      autoplayTimeout: 1000,
      autoplaySpeed: 1000,
      fluidSpeed: true,
      responsive: {
        0: {
          items: 2
        },
        600: {
          items: 4
        },
        1000: {
          items: 8
        }
      }
    })

  </script>


  <script>
    $('.Popular-course').owlCarousel({
      loop: true,
      margin: 0,
      autoplay: true,
      dots: false,
      nav: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 1
        },
        1000: {
          items: 3
        }
      }
    });
    $('.chatgpt-course').owlCarousel({
      loop: true,
      margin: 0,
      dots: false,
      autoplay: true,
      nav: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 1
        },
        1000: {
          items: 3
        }
      }
    });
    $('.InstructorSlider').owlCarousel({
      loop: true,
      margin: 0,
      dots: false,
      autoplay: true,
      nav: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 1
        },
        1000: {
          items: 3
        }
      }
    });

    $('.trending-course').owlCarousel({
      loop: true,
      margin: 0,
      dots: false,
      autoplay: true,
      nav: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 1
        },
        1000: {
          items: 3
        }
      }
    });

    $('.testimonials-theme').owlCarousel({
      loop: true,
      margin: 30,
      dots: false,
      autoplay: true,
      nav: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 1
        },
        1000: {
          items: 3
        }
      }
    });

    $('.Quality-theme').owlCarousel({
      loop: true,
      margin: 30,
      dots: false,
      autoplay: true,
      nav: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 1
        },
        1000: {
          items: 3
        }
      }
    });

    $('.LearnerSlider').owlCarousel({
      loop: true,
      margin: 30,
      dots: false,
      autoplay: true,
      nav: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 1
        },
        1000: {
          items: 3
        }
      }
    });

    $('.curriculumtab').owlCarousel({
      loop: false,
      margin: 10,
      dots: false,
      autoplay: false,
      nav: true,
      responsive: {
        0: {
          items: 2
        },
        600: {
          items: 3
        },
        1000: {
          items: 6
        }
      }
    });



  </script>
  <script>
    var input = document.querySelector('[name=phone]');
    var patt = new RegExp(input.getAttribute('pattern'));
    input.oninput = function (event) {
      if (patt.test(this.value)) {
        document.querySelector('#btnSubmit').disabled = false;
      }
      else {
        document.querySelector('#btnSubmit').disabled = true;
      }
    }
  </script>

  <!-- <script>
    const navbarMenu = document.getElementById("menu");

    // Toggle to show and hide dropdown menu
    const dropdown = document.querySelectorAll(".dropdown");

    dropdown.forEach((item) => {
      const dropdownToggle = item.querySelector(".dropdown-toggle");

      dropdownToggle.addEventListener("click", () => {
        const dropdownShow = document.querySelector(".dropdown-show");
        toggleDropdownItem(item);

        // Remove 'dropdown-show' class from other dropdown
        if (dropdownShow && dropdownShow != item) {
          toggleDropdownItem(dropdownShow);
        }
      });
    });

    // Function to display the dropdown menu
    const toggleDropdownItem = (item) => {
      const dropdownContent = item.querySelector(".dropdown-content");

      // Remove other dropdown that have 'dropdown-show' class
      if (item.classList.contains("dropdown-show")) {
        dropdownContent.removeAttribute("style");
        item.classList.remove("dropdown-show");
      } else {
        // Added max-height on active 'dropdown-show' class
        dropdownContent.style.height = dropdownContent.scrollHeight + "px";
        item.classList.add("dropdown-show");
      }
    };
  </script> -->
  <script>
    function handlePasteOTP(e) {
      var clipboardData = e.clipboardData || window.clipboardData || e.originalEvent.clipboardData;
      var pastedData = clipboardData.getData('Text');
      var arrayOfText = pastedData.toString().split('');
      /* for number only */
      if (isNaN(parseInt(pastedData, 10))) {
        e.preventDefault();
        return;
      }
      for (var i = 0; i < arrayOfText.length; i++) {
        if (i >= 0) {
          document.getElementById('otp-number-input-' + (i + 1)).value = arrayOfText[i];
        } else {
          return;
        }
      }
      e.preventDefault();
    }

    $(document).ready(function () {
      $('.otp-event').each(function () {
        var $input = $(this).find('.otp-number-input');
        var $submit = $(this).find('.otp-submit');
        $input.keydown(function (ev) {
          otp_val = $(this).val();
          if (ev.keyCode == 37) {
            $(this).prev().focus();
            ev.preventDefault();
          } else if (ev.keyCode == 39) {
            $(this).next().focus();
            ev.preventDefault();
          } else if (otp_val.length == 1 && ev.keyCode != 8 && ev.keyCode != 46) {
            otp_next_number = $(this).next();
            if (otp_next_number.length == 1 && otp_next_number.val().length == 0) {
              otp_next_number.focus();
            }
          } else if (otp_val.length == 0 && ev.keyCode == 8) {
            $(this).prev().val("");
            $(this).prev().focus();
          } else if (otp_val.length == 1 && ev.keyCode == 8) {
            $(this).val("");
          } else if (otp_val.length == 0 && ev.keyCode == 46) {
            next_input = $(this).next();
            next_input.val("");
            while (next_input.next().length > 0) {
              next_input.val(next_input.next().val());
              next_input = next_input.next();
              if (next_input.next().length == 0) {
                next_input.val("");
                break;
              }
            }
          }

        }).focus(function () {
          $(this).select();
          var otp_val = $(this).prev().val();
          if (otp_val === "") {
            $(this).prev().focus();
          } else if ($(this).next().val()) {
            $(this).next().focus();
          }
        }).keyup(function (ev) {
          otpCodeTemp = "";
          $input.each(function (i) {
            if ($(this).val().length != 0) {
              $(this).addClass('otp-filled-active');
            } else {
              $(this).removeClass('otp-filled-active');
            }
            otpCodeTemp += $(this).val();
          });
          if ($(this).val().length == 1 && ev.keyCode != 37 && ev.keyCode != 39) {
            $(this).next().focus();
            ev.preventDefault();
          }
          $input.each(function (i) {
            if ($(this).val() != '') {
              $submit.prop('disabled', false);
            } else {
              $submit.prop('disabled', true);
            }
          });

        });
        $input.on("paste", function (e) {
          window.handlePasteOTP(e);
        });
      });

    });
  </script>
  <script>
    function countdown() {
      var seconds = 30;
      function tick() {
        var counter = document.getElementById("counter");
        seconds--;
        counter.innerHTML =
          "0:" + (seconds < 10 ? "0" : "") + String(seconds);
        if (seconds > 0) {
          setTimeout(tick, 1000);
        } else {
          document.getElementById("verifiBtn").innerHTML = `
                <div id="ResendBtn">
                    <a href="#">Resend</a>
                </div>
            `;
          document.getElementById("counter").innerHTML = "";
        }
      }
      tick();
    }
    countdown();
  </script>
</body>


<!-- Mirrored from v1.iyda.in/programme.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 04 Jul 2025 06:39:06 GMT -->
</html>