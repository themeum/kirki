function serialize(mixed_value) {
  //  discuss at: http://phpjs.org/functions/serialize/
  // original by: Arpad Ray (mailto:arpad@php.net)
  // improved by: Dino
  // improved by: Le Torbi (http://www.letorbi.de/)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net/)
  // bugfixed by: Andrej Pavlovic
  // bugfixed by: Garagoth
  // bugfixed by: Russell Walker (http://www.nbill.co.uk/)
  // bugfixed by: Jamie Beck (http://www.terabit.ca/)
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net/)
  // bugfixed by: Ben (http://benblume.co.uk/)
  //	input by: DtTvB (http://dt.in.th/2008-09-16.string-length-in-bytes.html)
  //	input by: Martin (http://www.erlenwiese.de/)
  //		note: We feel the main purpose of this function should be to ease the transport of data between php & js
  //		note: Aiming for PHP-compatibility, we have to translate objects to arrays
  //   example 1: serialize(['Kevin', 'van', 'Zonneveld']);
  //   returns 1: 'a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}'
  //   example 2: serialize({firstName: 'Kevin', midName: 'van', surName: 'Zonneveld'});
  //   returns 2: 'a:3:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";s:7:"surName";s:9:"Zonneveld";}'

  var val, key, okey,
	ktype = '',
	vals = '',
	count = 0,
	_utf8Size = function(str) {
	  var size = 0,
		i = 0,
		l = str.length,
		code = '';
	  for (i = 0; i < l; i++) {
		code = str.charCodeAt(i);
		if (code < 0x0080) {
		  size += 1;
		} else if (code < 0x0800) {
		  size += 2;
		} else {
		  size += 3;
		}
	  }
	  return size;
	};
  _getType = function(inp) {
	var match, key, cons, types, type = typeof inp;

	if (type === 'object' && !inp) {
	  return 'null';
	}
	if (type === 'object') {
	  if (!inp.constructor) {
		return 'object';
	  }
	  cons = inp.constructor.toString();
	  match = cons.match(/(\w+)\(/);
	  if (match) {
		cons = match[1].toLowerCase();
	  }
	  types = ['boolean', 'number', 'string', 'array'];
	  for (key in types) {
		if (cons == types[key]) {
		  type = types[key];
		  break;
		}
	  }
	}
	return type;
  };
  type = _getType(mixed_value);

  switch (type) {
	case 'function':
	  val = '';
	  break;
	case 'boolean':
	  val = 'b:' + (mixed_value ? '1' : '0');
	  break;
	case 'number':
	  val = (Math.round(mixed_value) == mixed_value ? 'i' : 'd') + ':' + mixed_value;
	  break;
	case 'string':
	  val = 's:' + _utf8Size(mixed_value) + ':"' + mixed_value + '"';
	  break;
	case 'array':
	case 'object':
	  val = 'a';
	  /*
		if (type === 'object') {
		  var objname = mixed_value.constructor.toString().match(/(\w+)\(\)/);
		  if (objname == undefined) {
			return;
		  }
		  objname[1] = this.serialize(objname[1]);
		  val = 'O' + objname[1].substring(1, objname[1].length - 1);
		}
		*/

	  for (key in mixed_value) {
		if (mixed_value.hasOwnProperty(key)) {
		  ktype = _getType(mixed_value[key]);
		  if (ktype === 'function') {
			continue;
		  }


		  okey = (key.match(/^[0-9]+$/) ? parseInt(key, 10) : key);
		  vals += this.serialize(okey) + this.serialize(mixed_value[key]);
		  count++;
		}
	  }
	  val += ':' + count + ':{' + vals + '}';
	  break;
	case 'undefined':
	  // Fall-through
	default:
	  // if the JS object has a property which contains a null value, the string cannot be unserialized by PHP
	  val = 'N';
	  break;
  }
  if (type !== 'object' && type !== 'array') {
	  if ( type == 'string' && val.indexOf('}') != -1 ) {
	  } else {
			val += ';';
		}
  }
  return val;
}


function unserialize(data) {
  //  discuss at: http://phpjs.org/functions/unserialize/
  // original by: Arpad Ray (mailto:arpad@php.net)
  // improved by: Pedro Tainha (http://www.pedrotainha.com)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Chris
  // improved by: James
  // improved by: Le Torbi
  // improved by: Eli Skeggs
  // bugfixed by: dptr1988
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //  revised by: d3x
  //	input by: Brett Zamir (http://brett-zamir.me)
  //	input by: Martin (http://www.erlenwiese.de/)
  //	input by: kilops
  //	input by: Jaroslaw Czarniak
  //		note: We feel the main purpose of this function should be to ease the transport of data between php & js
  //		note: Aiming for PHP-compatibility, we have to translate objects to arrays
  //   example 1: unserialize('a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}');
  //   returns 1: ['Kevin', 'van', 'Zonneveld']
  //   example 2: unserialize('a:3:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";s:7:"surName";s:9:"Zonneveld";}');
  //   returns 2: {firstName: 'Kevin', midName: 'van', surName: 'Zonneveld'}

  var that = this,
	utf8Overhead = function(chr) {
	  // http://phpjs.org/functions/unserialize:571#comment_95906
	  var code = chr.charCodeAt(0);
	  if (code < 0x0080) {
		return 0;
	  }
	  if (code < 0x0800) {
		return 1;
	  }
	  return 2;
	};
  error = function(type, msg, filename, line) {
	throw new that.window[type](msg, filename, line);
  };
  read_until = function(data, offset, stopchr) {
	var i = 2,
	  buf = [],
	  chr = data.slice(offset, offset + 1);

	while (chr != stopchr) {
	  if ((i + offset) > data.length) {
		error('Error', 'Invalid');
	  }
	  buf.push(chr);
	  chr = data.slice(offset + (i - 1), offset + i);
	  i += 1;
	}
	return [buf.length, buf.join('')];
  };
  read_chrs = function(data, offset, length) {
	var i, chr, buf;

	buf = [];
	for (i = 0; i < length; i++) {
	  chr = data.slice(offset + (i - 1), offset + i);
	  buf.push(chr);
	  length -= utf8Overhead(chr);
	}
	return [buf.length, buf.join('')];
  };
  _unserialize = function(data, offset) {
	var dtype, dataoffset, keyandchrs, keys, contig,
	  length, array, readdata, readData, ccount,
	  stringlength, i, key, kprops, kchrs, vprops,
	  vchrs, value, chrs = 0,
	  typeconvert = function(x) {
		return x;
	  };

	if (!offset) {
	  offset = 0;
	}
	dtype = (data.slice(offset, offset + 1))
	  .toLowerCase();

	dataoffset = offset + 2;

	switch (dtype) {
	  case 'i':
		typeconvert = function(x) {
		  return parseInt(x, 10);
		};
		readData = read_until(data, dataoffset, ';');
		chrs = readData[0];
		readdata = readData[1];
		dataoffset += chrs + 1;
		break;
	  case 'b':
		typeconvert = function(x) {
		  return parseInt(x, 10) !== 0;
		};
		readData = read_until(data, dataoffset, ';');
		chrs = readData[0];
		readdata = readData[1];
		dataoffset += chrs + 1;
		break;
	  case 'd':
		typeconvert = function(x) {
		  return parseFloat(x);
		};
		readData = read_until(data, dataoffset, ';');
		chrs = readData[0];
		readdata = readData[1];
		dataoffset += chrs + 1;
		break;
	  case 'n':
		readdata = null;
		break;
	  case 's':
		ccount = read_until(data, dataoffset, ':');
		chrs = ccount[0];
		stringlength = ccount[1];
		dataoffset += chrs + 2;

		readData = read_chrs(data, dataoffset + 1, parseInt(stringlength, 10));
		chrs = readData[0];
		readdata = readData[1];
		dataoffset += chrs + 2;
		if (chrs != parseInt(stringlength, 10) && chrs != readdata.length) {
		  error('SyntaxError', 'String length mismatch');
		}
		break;
	  case 'a':
		readdata = {};

		keyandchrs = read_until(data, dataoffset, ':');
		chrs = keyandchrs[0];
		keys = keyandchrs[1];
		dataoffset += chrs + 2;

		length = parseInt(keys, 10);
		contig = true;

		for (i = 0; i < length; i++) {
		  kprops = _unserialize(data, dataoffset);
		  kchrs = kprops[1];
		  key = kprops[2];
		  dataoffset += kchrs;

		  vprops = _unserialize(data, dataoffset);
		  vchrs = vprops[1];
		  value = vprops[2];
		  dataoffset += vchrs;

		  if (key !== i)
			contig = false;

		  readdata[key] = value;
		}

		if (contig) {
		  array = new Array(length);
		  for (i = 0; i < length; i++)
			array[i] = readdata[i];
		  readdata = array;
		}

		dataoffset += 1;
		break;
	  default:
		error('SyntaxError', 'Unknown / Unhandled data type(s): ' + dtype);
		break;
	}
	return [dtype, dataoffset - offset, typeconvert(readdata)];
  };

  return _unserialize((data + ''), 0)[2];
}
