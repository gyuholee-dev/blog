<?php // main.php
$content = <<<HTML
  <section class="list tile">
    <div class="title xi-bookmark-o">바로가기</div>

    <ul class="tile">
      <li class="item wide">
        <div class="box link active" onclick="location.href='#'">
          <div class="bg" style="background-image:url('images/BI-header_r.png')"></div>
          <div class="post">
            <div class="title">PROFILE</div>
            <div class="summary"></div>
          </div>
        </div>
      </li>
      <li class="item">
        <div class="box link" onclick="location.href='#'">
          <div class="bg" style="background-image:url('images/slide/images(1).jpg')"></div>
          <div class="post">
            <div class="title">DEVELOPMENT</div>
            <div class="summary"></div>
          </div>
        </div>
      </li>
      <li class="item">
        <div class="box link" onclick="location.href='http\://www.artstation.com/geoflowerstudio'">
          <div class="bg" style="background-image:url('images/slide/images(2).jpg')"></div>
          <div class="post">
            <div class="title">ART &<br>GRAPHIC</div>
            <div class="summary"></div>
          </div>
        </div>
      </li>
      <li class="item">
        <div class="box link" onclick="location.href='https\://github.com/leegyuho-dev'">
          <div class="bg" style="background-image:url('images/slide/images(3).jpg')"></div>
          <div class="post">
            <div class="title">GITHUB</div>
            <div class="summary"></div>
          </div>
        </div>
      </li>
    </ul>

  </section>

  <section class="list tile">
    <div class="title xi-view-module">최신 게시물</div>

    <ul class="tile">
                
      <li class="item wide">
        <div class="box media" onclick="location.href='#'">
          <div class="bg" style="background-image:url('images/slide/images(4).jpg')"></div>
          <div class="post">
            <div class="title">오늘 사진</div>
            <div class="summary">사진설명 사진설명 사진설명 사진설명</div>
          </div>
        </div>
      </li>
      <li class="item">
        <div class="box">
          <div class="post">
            <div class="title">VSCode 설정</div>
            <div class="summary">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore molestiae architecto repellat eligendi, iusto magnam illum deserunt cumque unde voluptatibus tenetur nisi expedita doloremque quasi aliquid suscipit, temporibus omnis labore?</div>
          </div>
        </div>
      </li>
      <li class="item wide">
        <div class="box media" onclick="location.href='#'">
          <div class="bg" style="background-image:url('images/cat-typing.gif'); background-size: 100%;"></div>
          <div class="post">
            <div class="title">최근 비디오</div>
            <div class="summary">비디오설명 비디오설명 비디오설명</div>
          </div>
        </div>
      </li>

      <li class="item">
        <div class="box">
          <div class="post">
            <div class="title">안녕하세요...</div>
            <div class="summary">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore molestiae architecto repellat eligendi, iusto magnam illum deserunt cumque unde voluptatibus tenetur nisi expedita doloremque quasi aliquid suscipit, temporibus omnis labore?</div>
          </div>
        </div>
      </li>
      <li class="item wide">
        <div class="box media" onclick="location.href='#'">
          <div class="bg" style="background-image:url('images/slide/images(4).jpg')"></div>
          <div class="post">
            <div class="title">어제 사진</div>
            <div class="summary">사진설명 사진설명 사진설명 사진설명</div>
          </div>
        </div>
      </li>
      <li class="item">
        <div class="box">
          <div class="post">
            <div class="title">Chrome 개발자 도구</div>
            <div class="summary">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore molestiae architecto repellat eligendi, iusto magnam illum deserunt cumque unde voluptatibus tenetur nisi expedita doloremque quasi aliquid suscipit, temporibus omnis labore?</div>
          </div>
        </div>
      </li>
      <li class="item">
        <div class="box">
          <div class="post">
            <div class="title">SCSS 활용 기초</div>
            <div class="summary">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore molestiae architecto repellat eligendi, iusto magnam illum deserunt cumque unde voluptatibus tenetur nisi expedita doloremque quasi aliquid suscipit, temporibus omnis labore?</div>
          </div>
        </div>
      </li>

      <li class="item">
        <div class="box">
          <div class="post">
            <div class="title">야매 프론트엔드</div>
            <div class="summary">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore molestiae architecto repellat eligendi, iusto magnam illum deserunt cumque unde voluptatibus tenetur nisi expedita doloremque quasi aliquid suscipit, temporibus omnis labore?</div>
          </div>
        </div>
      </li>
      <li class="item">
        <div class="box">
          <div class="post">
            <div class="title">깃 설치 및 깃허브 설정</div>
            <div class="summary">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore molestiae architecto repellat eligendi, iusto magnam illum deserunt cumque unde voluptatibus tenetur nisi expedita doloremque quasi aliquid suscipit, temporibus omnis labore?</div>
          </div>
        </div>
      </li>
      <li class="item">
        <div class="box">
          <div class="post">
            <div class="title">스택오버플로우</div>
            <div class="summary">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore molestiae architecto repellat eligendi, iusto magnam illum deserunt cumque unde voluptatibus tenetur nisi expedita doloremque quasi aliquid suscipit, temporibus omnis labore?</div>
          </div>
        </div>
      </li>
      <li class="item">
        <div class="box">
          <div class="post">
            <div class="title">SQL 활용</div>
            <div class="summary">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore molestiae architecto repellat eligendi, iusto magnam illum deserunt cumque unde voluptatibus tenetur nisi expedita doloremque quasi aliquid suscipit, temporibus omnis labore?</div>
          </div>
        </div>
      </li>

    </ul>

    <div id="loading">
      <i class="xi-spin xi-spinner-3"></i>
    </div>
    
  </section>
HTML;