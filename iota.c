#include "libft.h"
#include <string.h>
#include <stdio.h>


static int			ft_cntsize(int n)
{
	int		i;

	i = 0;
	if (n < 0)
		i++;
	while (n != 0)
	{
		n = n / 10;
		i++;
	}
	return (i);
}

char				*ft_itoa(int n)
{
	char	*str;
	int		j;
	int		i;

	if (n == 0)
		return (ft_strdup("0"));
	j = ft_cntsize(n);
	i = n;
	if (n == -2147483648)
		return (ft_strdup("-2147483648"));
	str = (char*)malloc(sizeof(char) * (j + 1));
	if (str == NULL)
		return (NULL);
	str[j] = '\0';
	while (j--)
	{
		if (n < 0)
			n = -n;
		str[j] = (n % 10 + '0');

		printf("%c\n", str[j]);
		n = n / 10;
	}
	if (i < 0)
		str[0] = '-';
	return (str);
}


int main(int ac, char **av)
{
	printf("%s", ft_itoa(52));
	return (0);
}