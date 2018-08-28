/*
 * qtk_support.js
 *
 * Ketqua.net main site
 * Support functions for Thong ke nhanh
 */

/*
 * Generate an array of number according to sequence_type
 */
function generate_number_sequence(sequence_type)
{
    result = [];

    // The sequence type can be see in view_qtk_thongketonghop.tpl
    for (i = 0; i < 10; i++)
    {
        for (j = 0; j < 10; j++)
        {
            // i is the tens and j is the ones digit
            number_value = i * 10 + j;

            if (sequence_type == 0)
                // Tat cat
                result.push(number_value);
            if (sequence_type == 1 && (i + j) % 2 == 0)
            {
                // Tong chan
                result.push(number_value);
            }
            if (sequence_type == 2 && (i + j) % 2 == 1)
            {
                // Tong le
                result.push(number_value);
            }
            if (sequence_type == 3 && i % 2 == 0 && j % 2 == 0)
            {
                // Chan chan
                result.push(number_value);
            }
            if (sequence_type == 4 && i % 2 == 1 && j % 2 == 1)
            {
                // Le le
                result.push(number_value);
            }
            if (sequence_type == 5 && i % 2 == 0 && j % 2 == 1)
            {
                // Chan le
                result.push(number_value);
            }
            if (sequence_type == 6 && i % 2 == 1 && j % 2 == 0)
            {
                // Le chan
                result.push(number_value);
            }
            if (sequence_type == 7 && i == j)
            {
                // Bo kep
                result.push(number_value);
            }
            if (sequence_type == 8 && (i == j + 1 || i == j - 1))
            {
                // Sat kep
                result.push(number_value);
            }
        }
    }
    return result;
}
