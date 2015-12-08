var options = {
  thumbImages : [{
    title: 'Apache',
    linkUrl: 'http://httpd.apache.org',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1447913673/apache_yklao8.png'
  },{
    title: 'Bootstrap',
    linkUrl: 'http://getbootstrap.com',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1447913674/bootstrap_dzinxz.png'
  },{
    title: 'Bower',
    linkUrl: 'http://bower.io',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1447913676/bower_g46sr2.png'
  },{
    title: 'Browserify',
    linkUrl: 'http://browserify.org',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1449577781/browserify_faydig.png'
  },{
    title: 'Font-Awesome',
    linkUrl: 'http://fortawesome.github.io/Font-Awesome',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1447913674/fontawesome_xxyfgz.png'
  },{
    title: 'Git',
    linkUrl: 'http://git-scm.org',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1449577645/git_hl2mkh.png'
  },{
    title: 'GNU',
    linkUrl: 'http://www.gnu.org/',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1447913675/gnu_eoqfu6.png'
  },{
    title: 'Gulp',
    linkUrl: 'http://www.gulpjs.com/',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1449577462/gulp_dzrz0x.png'
  },{
    title: 'JQuery',
    linkUrl: 'http://jquery.com',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1447913675/jquery_likqfo.png'
  },{
    title: 'Laravel',
    linkUrl: 'http://laravel.com',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1447913674/laravel_h3wltk.png'
  },{
    title: 'Laravel-Collective',
    linkUrl: 'http://laravelcollective.com',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1447913675/laravelcollective_nrcvkw.png'
  },{
    title: 'LESS',
    linkUrl: 'http://lesscss.org',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1447913675/less_ef5oc3.png'
  },{
    title: 'Linux',
    linkUrl: 'http://linux.com',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1447913675/linux_lmwqop.png'
  },{
    title: 'MySQL',
    linkUrl: 'http://dev.mysql.com',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1447913675/mysql_eyzzsl.png'
  },{
    title: 'Node.js',
    linkUrl: 'http://nodejs.org',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1447913675/nodejs_vzpujv.png'
  },{
    title: 'PHP',
    linkUrl: 'http://php.net',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1447913676/php_wcnzwd.png'
  },{
    title: 'React',
    linkUrl: 'http://facebook.github.io/react',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1449577462/reactjs_pn2skc.png'
  },{
    title: 'Ubuntu',
    linkUrl: 'http://ubuntu.com',
    imgUrl: 'http://res.cloudinary.com/kurapikats/image/upload/v1447913676/ubuntu_boylkx.png'
  }]
};

var OpenSourceImg = React.createClass({
  render: function() {
    return (
      <a href={this.props.linkUrl} target="_blank">
        <img src={this.props.imgUrl} title={this.props.title} alt={this.props.title} />
      </a>
    );
  }
});

var ImagesCon = React.createClass({
  render: function() {
    var ImgList = this.props.thumbImages.map(function(imgProps){
      return <OpenSourceImg {...imgProps} key={imgProps.title} />
    });

    return (
      <div>
        {ImgList}
      </div>
    );
  }
});

var Main = React.createClass({
  render: function() {
    return (
      <ImagesCon {...options} />
    );
  }
});

ReactDOM.render(<Main />, document.querySelector('.opensource-gallery'));
