IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M004_ACT1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M004_ACT1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- 
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Insert or update data for customer
--*  
--*  作成日/create date			:	2024/02/19
--*　作成者/creater				:	HaiNN - ANS901
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M004_ACT1
	@P_customer_cd					INT				= 0
,	@P_billing_source_cd			SMALLINT		= 0
,	@P_customer_nm					NVARCHAR(50)	= N''
,	@P_customer_kn_nm				NVARCHAR(50)	= N''
,	@P_customer_ab_nm				NVARCHAR(30)	= N''
,	@P_customer_zip					NVARCHAR(8)		= N''
,	@P_customer_address1			NVARCHAR(50)	= N''
,	@P_customer_address2			NVARCHAR(50)	= N''
,	@P_customer_address3			NVARCHAR(100)	= N''
,	@P_customer_tel					NVARCHAR(20)	= N''
,	@P_customer_fax					NVARCHAR(20)	= N''
,	@P_customer_department_nm		NVARCHAR(30)	= N''
,	@P_customer_manager_nm			NVARCHAR(30)	= N''
,	@P_customer_mail_address		NVARCHAR(255)	= N''
,	@P_customer_class_div1			SMALLINT		= 0
,	@P_customer_class_div2			SMALLINT		= 0
,	@P_customer_class_div3			SMALLINT		= 0
,	@P_billing_nm					NVARCHAR(50)	= N''
,	@P_billing_zip					NVARCHAR(8)		= N''
,	@P_billing_address1				NVARCHAR(50)	= N''
,	@P_billing_address2				NVARCHAR(50)	= N''
,	@P_billing_address3				NVARCHAR(100)	= N''
,	@P_billing_tel					NVARCHAR(20)	= N''
,	@P_billing_fax					NVARCHAR(20)	= N''
,	@P_billing_department_nm		NVARCHAR(30)	= N''
,	@P_billing_manager_nm			NVARCHAR(30)	= N''
,	@P_billing_mail_address			NVARCHAR(255)	= N''
,	@P_billing_closing_div			SMALLINT		= 0
,	@P_transfer_date1				SMALLINT		= 0
,	@P_transfer_date2				SMALLINT		= 0
,	@P_sales_employee_cd			NVARCHAR(5)		= N''
,	@P_price_list					SMALLINT		= 0
,	@P_reason_for_closure			NVARCHAR(50)	= N''
,	@P_remarks						NVARCHAR(100)	= N''
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
	-- variable general
		@w_time						DATETIME2		=	SYSDATETIME()
	,	@ERR_TBL					ERRTABLE
	-- variable log
    ,   @w_prs_mode					NVARCHAR(200)   =   N'Insert'
    ,   @w_prs_result				NVARCHAR(200)   =   N'OK'
	,	@w_remarks					NVARCHAR(200)	=	N''
	,	@w_table_key				NVARCHAR(200)	=	N'customer_cd=' + CONVERT(NVARCHAR, @P_customer_cd)

	IF EXISTS(SELECT 1 FROM M004 WITH(NOLOCK) WHERE customer_cd = @P_customer_cd AND del_flg = 0)
	BEGIN
		SET @w_prs_mode = N'Update'
	END

	IF ISNULL(@P_sales_employee_cd, '') <> '' AND NOT EXISTS(SELECT 1 FROM M002 WITH(NOLOCK) WHERE user_cd = @P_sales_employee_cd AND del_flg <> 1)
	BEGIN
		SET @w_prs_result							=   N'NG'
		SET	@w_remarks								=	N'該当データが存在しません'

		INSERT INTO @ERR_TBL
		SELECT  
			N'E012'
		,   'sales_employee_cd'
		,   0
		,   1
		,   0
		,	''
		,   @w_remarks

		GOTO COMPLETE_QUERY
	END

	-- START TRANSACTION 
	BEGIN TRANSACTION
	-- TRY CATCH EXCEPTION
	BEGIN TRY
		IF EXISTS(SELECT 1 FROM M004 WITH(NOLOCK) WHERE customer_cd = @P_customer_cd)
		BEGIN
			UPDATE M004 SET
				billing_source_cd		= @P_billing_source_cd		
			,	customer_nm				= @P_customer_nm				
			,	customer_kn_nm			= @P_customer_kn_nm			
			,	customer_ab_nm			= @P_customer_ab_nm			
			,	customer_zip			= @P_customer_zip				
			,	customer_address1		= @P_customer_address1		
			,	customer_address2		= @P_customer_address2		
			,	customer_address3		= @P_customer_address3		
			,	customer_tel			= @P_customer_tel				
			,	customer_fax			= @P_customer_fax				
			,	customer_department_nm	= @P_customer_department_nm	
			,	customer_manager_nm		= @P_customer_manager_nm		
			,	customer_mail_address	= @P_customer_mail_address	
			,	customer_class_div1		= @P_customer_class_div1		
			,	customer_class_div2		= @P_customer_class_div2		
			,	customer_class_div3		= @P_customer_class_div3		
			,	billing_nm				= @P_billing_nm				
			,	billing_zip				= @P_billing_zip				
			,	billing_address1		= @P_billing_address1			
			,	billing_address2		= @P_billing_address2			
			,	billing_address3		= @P_billing_address3			
			,	billing_tel				= @P_billing_tel				
			,	billing_fax				= @P_billing_fax
			,	billing_department_nm	= @P_billing_department_nm	
			,	billing_manager_nm		= @P_billing_manager_nm		
			,	billing_mail_address	= @P_billing_mail_address		
			,	billing_closing_div		= @P_billing_closing_div		
			,	transfer_date1			= @P_transfer_date1			
			,	transfer_date2			= @P_transfer_date2			
			,	sales_employee_cd		= @P_sales_employee_cd		
			,	price_list				= @P_price_list				
			,	reason_for_closure		= @P_reason_for_closure		
			,	remarks					= @P_remarks					
			,	upd_user_cd				= @P_act_user_cd
			,	upd_prg					= @P_prg
			,	upd_ip					= @P_ip
			,	upd_tm					= @w_time
			,	del_user_cd				= NULL
			,	del_prg					= NULL
			,	del_ip					= NULL
			,	del_tm					= NULL
			,	del_flg					= 0
			WHERE
				customer_cd				= @P_customer_cd
		END
		ELSE
		BEGIN
			EXEC SPC_S001_INQ1 'M004', @P_customer_cd OUT, @P_act_user_cd, @P_prg, @P_ip
			SET @w_table_key = N'customer_cd=' + CONVERT(NVARCHAR, @P_customer_cd)
			INSERT INTO M004
			SELECT
				@P_customer_cd
			,	@P_billing_source_cd		
			,	@P_customer_nm				
			,	@P_customer_kn_nm			
			,	@P_customer_ab_nm			
			,	@P_customer_zip				
			,	@P_customer_address1		
			,	@P_customer_address2		
			,	@P_customer_address3		
			,	@P_customer_tel				
			,	@P_customer_fax				
			,	@P_customer_department_nm	
			,	@P_customer_manager_nm		
			,	@P_customer_mail_address	
			,	@P_customer_class_div1		
			,	@P_customer_class_div2		
			,	@P_customer_class_div3		
			,	@P_billing_nm				
			,	@P_billing_zip				
			,	@P_billing_address1			
			,	@P_billing_address2			
			,	@P_billing_address3			
			,	@P_billing_tel				
			,	@P_billing_fax		
			,	@P_billing_department_nm	
			,	@P_billing_manager_nm		
			,	@P_billing_mail_address		
			,	@P_billing_closing_div		
			,	@P_transfer_date1			
			,	@P_transfer_date2			
			,	@P_sales_employee_cd		
			,	@P_price_list				
			,	@P_reason_for_closure		
			,	@P_remarks						
			,	@P_act_user_cd
			,	@P_prg
			,	@P_ip
			,	@w_time
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	0
		END
	END TRY
	BEGIN CATCH
		SET @w_prs_result	=	'NG'
		SET @w_remarks		=	N'Error'                                                           + CHAR(13) + CHAR(10) +
								N'Procedure : ' + ISNULL(ERROR_PROCEDURE(), N'???')                + CHAR(13) + CHAR(10) +
								N'Line : '      + ISNULL(CAST(ERROR_LINE() AS NVARCHAR(10)), N'0') + CHAR(13) + CHAR(10) +
								N'Message : '   + ISNULL(ERROR_MESSAGE(), N'An unexpected error occurred.')
        DELETE FROM @ERR_TBL
        INSERT INTO @ERR_TBL
        SELECT  
            N'E009'
        ,   ''
        ,   0
        ,   999
        ,   0
		,	''
        ,   @w_remarks
	END CATCH
    IF EXISTS (SELECT 1 FROM @ERR_TBL)
	BEGIN
		IF(@@TRANCOUNT > 0)
        BEGIN
            ROLLBACK TRANSACTION
        END
	END
	ELSE
	BEGIN
		DELETE FROM @ERR_TBL
		IF(@@TRANCOUNT > 0)
        BEGIN
            COMMIT TRANSACTION
        END
	END
    -- Insert statements for procedure here
	COMPLETE_QUERY:

	EXEC SPC_S999_ACT1
		@P_act_user_cd
	,	@P_prg
	,	@w_prs_mode
	,	@w_table_key
	,	@w_prs_result
	,	@w_remarks

	SELECT * FROM @ERR_TBL
	SELECT @P_customer_cd AS customer_cd
END
GO
