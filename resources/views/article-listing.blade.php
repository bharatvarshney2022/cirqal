@include('common.header_body')

<div class="mid-area">  
    <div class="container-fluid">
        <div class="post-area"> 
            <div class="post-box">
                <div class="post-user-top">
                    <div class="PUT-img">
                        <img src="{{ asset('public/assets/') }}/images/profile-1.png" alt="">
                    </div>
                    <div class="PUT-name">
                        <span><a href="">Jane Cooper</a></span>
                    </div>
                </div>
                <div class="post-info">
                    <div class="post-info-img">
                        <img src="{{ asset('public/assets/') }}/images/post-1.png" alt="">
                    </div>
                    <div class="post-info-cont">
                        <h3>Lorem Ipsum is simply dummy printing industry.</h3>                         
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                    </div>
                </div>
                <div class="post-footer-like">
                    <ul>    
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/like-icon.svg" alt="">
                                <span>2.4k</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/comment-icon.svg" alt="">
                                <span>175</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/retwo-icon.svg" alt="">
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/share-icon.svg" alt="">
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/bookmark-icon.svg" alt="">
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div class="post-read-time">
                    <ul>
                        <li>
                            <img src="{{ asset('public/assets/') }}/images/calendar-icon.svg" alt="" class="post-read-img">
                            <span>05-02-2021</span>
                        </li>
                        <li>
                            <img src="{{ asset('public/assets/') }}/images/read-clock-icon.svg" alt="" class="post-read-img">
                            <span>5 Minutes to read</span>
                        </li>
                    </ul>                       
                </div>
            </div>
            <div class="post-box">
                <div class="post-user-top">
                    <div class="PUT-img">
                        <img src="{{ asset('public/assets/') }}/images/profile-1.png" alt="">
                    </div>
                    <div class="PUT-name">
                        <span><a href="">Jane Cooper</a></span>
                    </div>
                </div>
                <div class="post-info">
                    <div class="post-info-img">
                        <img src="{{ asset('public/assets/') }}/images/post-1.png" alt="">                            
                    </div>
                    <div class="post-info-cont">
                        <h3>Lorem Ipsum is simply dummy printing industry.</h3>                         
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                    </div>
                </div>
                <div class="post-footer-like">
                    <ul>    
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/like-icon.svg" alt="">
                                <span>2.4k</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/comment-icon.svg" alt="">
                                <span>175</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/retwo-icon.svg" alt="">
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/share-icon.svg" alt="">
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/bookmark-icon.svg" alt="">
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="topic-follow-area">
            <div class="custom-heading">
                <span>
                    Topics to follow
                </span>
            </div>
            <div class="topics_follow owl-carousel">
                <div class="item">
                    @foreach($categoryData as $k => $row)
                    <button type="button" class="follow-topic-btn">{{ $row->name }}</button>
                    @if(($k % 3) == 2) </div><div class="item"> @endif
                    @endforeach
                </div>
                
            </div>
            <div class="more-topic"><a href="">More topics</a></div>                
        </div>
        
        <div class="people-follow-area">
            <div class="custom-heading">
                <span>
                    People to Follow
                </span>
            </div>
            <div class="people_follow owl-carousel">
                <div class="item">
                  <div class="people-follow-box">   
                      <i class="people-follow-img"><img src="{{ asset('public/assets/') }}/images/profile-6.png" alt=""></i>
                      <span>Albert</span>
                  </div>
                </div>
                <div class="item">
                  <div class="people-follow-box">   
                      <i class="people-follow-img"><img src="{{ asset('public/assets/') }}/images/people-follow-2.png" alt=""></i>
                      <span>Fisher</span>
                  </div>
                </div>
                <div class="item">
                  <div class="people-follow-box">   
                      <i class="people-follow-img"><img src="{{ asset('public/assets/') }}/images/people-follow-3.png" alt=""></i>
                      <span>Floyd</span>
                  </div>
                </div>
                <div class="item">
                  <div class="people-follow-box">   
                      <i class="people-follow-img"><img src="{{ asset('public/assets/') }}/images/people-follow-4.png" alt=""></i>
                      <span>Brooklyn</span>
                  </div>
                </div>
                <div class="item">
                  <div class="people-follow-box">   
                      <i class="people-follow-img"><img src="{{ asset('public/assets/') }}/images/profile-6.png" alt=""></i>
                      <span>Albert</span>
                  </div>
                </div>
                <div class="item">
                  <div class="people-follow-box">   
                      <i class="people-follow-img"><img src="{{ asset('public/assets/') }}/images/people-follow-2.png" alt=""></i>
                      <span>Fisher</span>
                  </div>
                </div>
            </div>              
        </div>
        
        <div class="post-area"> 
            <div class="custom-heading">
                <span>
                    Trending on Two
                </span>
            </div>
            <div class="post-box">
                <div class="post-user-top">
                    <div class="PUT-img">
                        <img src="{{ asset('public/assets/') }}/images/profile-1.png" alt="">
                    </div>
                    <div class="PUT-name">
                        <span><a href="">Jane Cooper</a></span>
                    </div>
                </div>
                <div class="post-info">
                    <div class="post-info-img">
                        <img src="{{ asset('public/assets/') }}/images/post-1.png" alt="">                            
                    </div>
                    <div class="post-info-cont">
                        <h3>Lorem Ipsum is simply dummy printing industry.</h3>                         
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                    </div>
                </div>
                <div class="post-footer-like">
                    <ul>    
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/like-icon.svg" alt="">
                                <span>2.4k</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/comment-icon.svg" alt="">
                                <span>175</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/retwo-icon.svg" alt="">
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/share-icon.svg" alt="">
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/bookmark-icon.svg" alt="">
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div class="post-read-time">
                    <ul>
                        <li>
                            <img src="{{ asset('public/assets/') }}/images/calendar-icon.svg" alt="" class="post-read-img">
                            <span>05-02-2021</span>
                        </li>
                        <li>
                            <img src="{{ asset('public/assets/') }}/images/read-clock-icon.svg" alt="" class="post-read-img">
                            <span>5 Minutes to read</span>
                        </li>
                    </ul>                       
                </div>
            </div>
            <div class="post-box">
                <div class="post-user-top">
                    <div class="PUT-img">
                        <img src="{{ asset('public/assets/') }}/images/profile-1.png" alt="">
                    </div>
                    <div class="PUT-name">
                        <span><a href="">Jane Cooper</a></span>
                    </div>
                </div>
                <div class="post-info">
                    <div class="post-info-img">
                        <img src="{{ asset('public/assets/') }}/images/post-1.png" alt="">                            
                    </div>
                    <div class="post-info-cont">
                        <h3>Lorem Ipsum is simply dummy printing industry.</h3>                         
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                    </div>
                </div>
                <div class="post-footer-like">
                    <ul>    
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/like-icon.svg" alt="">
                                <span>2.4k</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/comment-icon.svg" alt="">
                                <span>175</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/retwo-icon.svg" alt="">
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/share-icon.svg" alt="">
                            </button>
                        </li>
                        <li>
                            <button type="button" class="PFL-button">
                                <img src="{{ asset('public/assets/') }}/images/bookmark-icon.svg" alt="">
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        
    </div>
</div>


@include('common.footer_body')