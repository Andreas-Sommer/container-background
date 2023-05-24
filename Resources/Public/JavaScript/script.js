/*
 * Container Background Image Set
 * Copyright (c) 2023 Andreas Sommer <sommer@belsignum.com>, belsignum UG
 * All rights reserved
 */

window.addEventListener('DOMContentLoaded', () => {
    containerBackground();
});

function containerBackground() {
    let cbItems = document.querySelectorAll('div[data-cb-image]');
    cbItems.forEach((item, index) => {
        let img = item.dataset.cbImage;
        let srcs = item.dataset.cbImageSet.split(/,\s|,/);
        let dimensions = item.dataset.cbDimensions.split(/,\s|,/);
        let style = item.getAttribute('style') ? item.getAttribute('style') : '';
        style = style.replace(/;$/, '') + ';';
        style += 'background-image: url("' + img + '");';
        style += 'background-image: -webkit-image-set( ';
        style += generateImageSetStr(srcs);
        style += ');';
        style += 'background-image: image-set(';
        style += generateImageSetStr(srcs);
        style += ');';
        style += 'background-image: image-set(';
        style += generateImageSetStr(srcs, dimensions);
        style += ' );';

        item.setAttribute('style', style);
    });
}

function generateImageSetStr(srcs, dimensions = false) {
    let srcSet = '';
    for (let i = 0; i < srcs.length; i++) {
        if (srcs[i] === '' || dimensions[i] === '') {
            continue;
        }
        if (i > 0) {
            srcSet += ', '
        }
        srcSet += 'url("' + srcs[i] + '") ';
        if (dimensions !== false && Array.isArray(dimensions)) {
            srcSet += dimensions[i];
        } else {
            srcSet += (i + 1) + 'x';
        }
    }
    return srcSet;
}