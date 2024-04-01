IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M004_INQ2]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M004_INQ2
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M004_INQ2
--****************************************************************************************	
--*   											
--*  処理概要/process overview	:	Search list of customer
--*  
--*  作成日/create date			:	2024/02/27
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M004_INQ2
	@P_customer_cd					INT				= 0
,	@P_billing_source_cd			INT				= 0
,	@P_customer_nm					NVARCHAR(50)	= N''
,	@P_customer_kn_nm				NVARCHAR(50)	= N''
,	@P_customer_ab_nm				NVARCHAR(30)	= N''
,	@P_customer_tel					NVARCHAR(20)	= N''
,	@P_customer_class_div1			INT				= 0
,	@P_customer_class_div2			INT				= 0
,	@P_customer_class_div3			INT				= 0
,	@P_billing_closing_div			INT				= 0
,	@P_sales_employee_cd			NVARCHAR(5)		= 0
,	@P_page_size					INT				= 50
,	@P_page							INT				= 1
,	@P_sort_column					NVARCHAR(50)	= N'customer_cd'
,	@P_sort_type					NVARCHAR(10)	= N'ASC'
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE
		@w_totalRecord				INT = 0
	,	@w_maxPage					INT = 0
	,	@w_offset					INT = 0
	,	@w_sql						NVARCHAR(MAX)

	CREATE TABLE #M004_TMP1 (
		customer_cd					INT
	,	billing_source_cd			INT
	,	customer_nm					NVARCHAR(50)
	,	customer_kn_nm				NVARCHAR(50)
	,	customer_ab_nm				NVARCHAR(30)
	,	customer_mail_address		NVARCHAR(255)
	,	customer_tel				NVARCHAR(20)
	,	customer_class_div1			INT
	,	customer_class_div2			INT
	,	customer_class_div3			INT
	,	billing_closing_div			INT
	,	transfer_date1				INT
	,	transfer_date2				INT
	,	sales_employee_cd			NVARCHAR(5)
	)

	CREATE TABLE #M004_TMP (
		customer_cd					INT
	,	billing_source_nm			NVARCHAR(50)
	,	customer_nm					NVARCHAR(50)
	,	customer_kn_nm				NVARCHAR(50)
	,	customer_ab_nm				NVARCHAR(30)
	,	customer_mail_address		NVARCHAR(255)
	,	customer_tel				NVARCHAR(20)
	,	customer_class_div1_nm		NVARCHAR(50)
	,	customer_class_div2_nm		NVARCHAR(50)
	,	customer_class_div3_nm		NVARCHAR(50)
	,	billing_closing_div_nm		NVARCHAR(50)
	,	transfer_date1_nm			NVARCHAR(50)
	,	transfer_date2_nm			NVARCHAR(50)
	,	sales_employee_cd			NVARCHAR(50)
	)

	INSERT INTO #M004_TMP1
	SELECT
		M004.customer_cd
	,	M004.billing_source_cd
	,   M004.customer_nm
	,   M004.customer_kn_nm
	,   M004.customer_ab_nm
	,   M004.customer_mail_address
	,   M004.customer_tel
	,   M004.customer_class_div1
	,   M004.customer_class_div2
	,   M004.customer_class_div3
	,   M004.billing_closing_div
	,   M004.transfer_date1
	,   M004.transfer_date2
	,   M004.sales_employee_cd
	FROM M004 WITH(NOLOCK)
	WHERE (
		@P_customer_cd					= 0
	OR	M004.customer_cd				= @P_customer_cd
	)
	AND (
		@P_customer_nm					= ''
	OR	M004.customer_nm				LIKE '%' + @P_customer_nm + '%'
	)
	AND (
		@P_customer_kn_nm				= ''
	OR	M004.customer_kn_nm				LIKE '%' + @P_customer_kn_nm + '%'
	)
	AND (
		@P_customer_ab_nm				= ''
	OR	M004.customer_ab_nm				LIKE '%' + @P_customer_ab_nm + '%'
	)
	AND (
		@P_customer_tel					= ''
	OR	M004.customer_tel				LIKE '%' + @P_customer_tel + '%'
	)
	AND (
		@P_sales_employee_cd			= ''
	OR	M004.sales_employee_cd			= @P_sales_employee_cd
	)
	AND (
		@P_billing_source_cd			= 0
	OR	M004.billing_source_cd			= @P_billing_source_cd
	)
	AND (
		@P_customer_class_div1			= 0
	OR	M004.customer_class_div1		= @P_customer_class_div1
	)
	AND (
		@P_customer_class_div2			= 0
	OR	M004.customer_class_div2		= @P_customer_class_div2
	)
	AND (
		@P_customer_class_div3			= 0
	OR	M004.customer_class_div3		= @P_customer_class_div3
	)
	AND (
		@P_billing_closing_div			= 0
	OR	M004.billing_closing_div		= @P_billing_closing_div
	)
	AND M004.del_flg					<> 1

	INSERT INTO #M004_TMP
	SELECT
		#M004_TMP1.customer_cd
	,	M001.company_nm1
	,   #M004_TMP1.customer_nm
	,   #M004_TMP1.customer_kn_nm
	,   #M004_TMP1.customer_ab_nm
	,   #M004_TMP1.customer_mail_address
	,   #M004_TMP1.customer_tel
	,   customer_class_div1.[name]
	,   customer_class_div2.[name]
	,   customer_class_div3.[name]
	,   billing_closing_div.[name]
	,   transfer_date1.[name]
	,   transfer_date2.[name]
	,   M002.user_nm
	FROM #M004_TMP1 WITH(NOLOCK)
	LEFT JOIN M001																ON (
		#M004_TMP1.billing_source_cd	= M001.company_cd
	AND M001.del_flg					<> 1
	)
	LEFT JOIN M401						AS customer_class_div1 WITH(NOLOCK)		ON (
		#M004_TMP1.customer_class_div1	= customer_class_div1.name_cd
	AND customer_class_div1.name_div	= 'customer_class_div1'
	)
	LEFT JOIN M401						AS customer_class_div2 WITH(NOLOCK)		ON (
		#M004_TMP1.customer_class_div2	= customer_class_div2.name_cd
	AND customer_class_div2.name_div	= 'customer_class_div2'
	)
	LEFT JOIN M401						AS customer_class_div3 WITH(NOLOCK)		ON (
		#M004_TMP1.customer_class_div3	= customer_class_div3.name_cd
	AND customer_class_div3.name_div	= 'customer_class_div3'
	)
	LEFT JOIN M401						AS billing_closing_div WITH(NOLOCK)		ON (
		#M004_TMP1.billing_closing_div	= billing_closing_div.name_cd
	AND billing_closing_div.name_div	= 'billing_closing_div'
	)
	LEFT JOIN M401						AS transfer_date1 WITH(NOLOCK)		ON (
		#M004_TMP1.transfer_date1		= transfer_date1.name_cd
	AND transfer_date1.name_div			= 'transfer_date1'
	)
	LEFT JOIN M401						AS transfer_date2 WITH(NOLOCK)		ON (
		#M004_TMP1.transfer_date2		= transfer_date2.name_cd
	AND transfer_date2.name_div			= 'transfer_date2'
	)
	LEFT JOIN M002																ON (
		#M004_TMP1.sales_employee_cd	= M002.user_cd
	AND M002.del_flg					<> 1
	)

	SELECT @w_totalRecord = COUNT(customer_cd) FROM #M004_TMP1
	SET @w_maxPage = @w_totalRecord / @P_page_size + IIF(@w_totalRecord % @P_page_size > 0, 1, 0)
	IF @P_page > @w_maxPage
	BEGIN
		SET @P_page = @w_maxPage
	END
	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	SET @w_offset = (@P_page - 1) * @P_page_size

	SET @w_sql = 
		'SELECT
			*
		FROM #M004_TMP
		ORDER BY
		' +	ISNULL(NULLIF(@P_sort_column, ''), 'customer_cd') + ' '  + ISNULL(NULLIF(@P_sort_type, ''), 'ASC') + '
		OFFSET ' + CONVERT(NVARCHAR, @w_offset) + '
		ROWS FETCH NEXT ' + CONVERT(NVARCHAR, @P_page_size) + ' ROWS ONLY'
	EXEC(@w_sql)

	SELECT
		@w_totalRecord		AS totalRecord
	,	@P_page				AS [page]
	,	@P_page_size		AS pageSize

	DROP TABLE IF EXISTS #M004_TMP1
	DROP TABLE IF EXISTS #M004_TMP
END
GO
