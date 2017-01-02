# -*- coding: utf-8 -*-
import datetime
import sys
import os
import cakephp_theme
from sphinx.highlighting import lexers
from pygments.lexers.php import PhpLexer

########################
# Begin Customizations #
########################

maintainer = u'josegonzalez'
project = u'cakephp-mail-preview'
project_pretty_name = u'CakePHP Mail Preview'
copyright = u'%d, Jose Diaz-Gonzalez' % datetime.datetime.now().year
version = '1.0.0'
release = '1.0.0'
html_title = 'CakePHP Mail Preview'
html_context = {
    'maintainer': maintainer,
    'project_pretty_name': project_pretty_name,
    'projects': {
        'Annotation Control List': 'https://cakephp-annotation-control-list.readthedocs.io/',
        'Entity Versioning': 'https://cakephp-version.readthedocs.io/',
        'Fractal Entities': 'https://cakephp-fractal-entities.readthedocs.io/',
        'Mail Preview': 'https://cakephp-mail-preview.readthedocs.io/',
        'Queueing': 'https://cakephp-queuesadilla.readthedocs.io/',
        'Upload Behavior': 'https://cakephp-upload.readthedocs.io/',
    }
}

htmlhelp_basename = 'cakephp-mail-preview'
latex_documents = [
    ('index', 'cakephp-mail-preview.tex', u'cakephp-mail-preview',
     u'Jose Diaz-Gonzalez', 'manual'),
]
man_pages = [
    ('index', 'cakephp-mail-preview', u'CakePHP Mail Preview Documentation',
     [u'Jose Diaz-Gonzalez'], 1)
]

texinfo_documents = [
    ('index', 'cakephp-mail-preview', u'CakePHP Mail Preview Documentation',
     u'Jose Diaz-Gonzalez', 'cakephp-mail-preview', 'Preview emails during development',
     'Miscellaneous'),
]

branch = 'master'

########################
#  End Customizations  #
########################

# -- General configuration ------------------------------------------------

extensions = [
    'sphinx.ext.todo',
    'sphinxcontrib.phpdomain',
    'cakephp_theme',
]

templates_path = ['_templates']
source_suffix = '.rst'
master_doc = 'contents'
exclude_patterns = [
    '_build',
    '_themes',
    '_partials',
]

pygments_style = 'sphinx'
highlight_language = 'php'

# -- Options for HTML output ----------------------------------------------

html_theme = 'cakephp_theme'
html_theme_path = [cakephp_theme.get_html_theme_path()]
html_static_path = []
html_last_updated_fmt = '%b %d, %Y'
html_sidebars = {
    '**': ['globaltoc.html', 'localtoc.html']
}

# -- Options for LaTeX output ---------------------------------------------

latex_elements = {
}

lexers['php'] = PhpLexer(startinline=True)
lexers['phpinline'] = PhpLexer(startinline=True)
lexers['php-annotations'] = PhpLexer(startinline=True)
primary_domain = "php"
