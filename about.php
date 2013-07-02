<?php

$title_stub = 'About This Software';
$about = 1;
require_once( './_header.inc' );

?>

<h1>About This Software</h1>

<p>This software was written by
<a href="http://www.matcmp.ncc.edu/~gansonj">Prof. Jared Ganson</a> and
<a href="http://www.matcmp.ncc.edu/~cmerlo/">Prof. Christopher Merlo</a>
of the <a href="http://www.matcmp.ncc.edu/">Department of Mathematics,
Computer Science, and Information Technology</a> of
<a href="http://www.ncc.edu/">Nassau Community College</a>.
It was written using the programming languages
<a href="http://www.php.net/">PHP</a> and
<a href="http://en.wikipedia.org/wiki/JavaScript">JavaScript</a>, and the
<a href="http://twitter.github.io/bootstrap/">Bootstrap</a> and
<a href="http://jquery.com/">jQuery</a> libraries.  These resources are all
<a href="http://opensource.org/">Open Source</a>, meaning that anybody
can view, share, or change the programmers' instructions at any time.
The programmers used the open-source IDE
<a href="http://www.aptana.com/">Aptana Studio</a> for development,
and tested extensively in the latest versions of
<a href="http://www.mozilla.org/en-US/firefox/new/">Firefox</a>,
<a href="http://www.google.com/chrome/">Chrome</a>,
<a href="http://www.apple.com/safari/">Safari</a>,
<a href="http://www.opera.com">Opera</a>, and other web browsers.</p>

<p>Faculty passwords are stored and verified using the
<a href="http://en.wikipedia.org/wiki/Bcrypt">bcrypt</a> key derivation
function of the
<a href="http://en.wikipedia.org/wiki/Blowfish_(cipher)">Blowfish</a> cipher,
which is in the public domain, and has not yet been cryptanalyzed.
Additionally, bcrypt is salted and adaptive for increased security.  Your
password is, in mathematical terms, unreadable by anybody.</p>

<p>While the software keeps track of <i>whether</i> you've voted in a given
election, there is no way to tell <i>how</i> you voted, since your electronic
ballot contains absolutely no identifying information.</p>

<?php

require_once( './_footer.inc' );

?>
